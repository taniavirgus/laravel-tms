<?php

namespace App\Http\Controllers;

use App\Enums\GenderType;
use App\Enums\ReligionType;
use App\Enums\StatusType;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->authorizeResource(Employee::class);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');
    $position_id = $request->input('position_id');
    $department_id = $request->input('department_id');
    $status = $request->input('status');

    $employees = Employee::query()
      ->with(['position', 'department'])
      ->when($search, function ($q) use ($search) {
        $q->where(function ($query) use ($search) {
          $query->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
        });
      })
      ->when($position_id, function ($q) use ($position_id) {
        $q->where('position_id', $position_id);
      })
      ->when($department_id, function ($q) use ($department_id) {
        $q->where('department_id', $department_id);
      })
      ->when($status, function ($q) use ($status) {
        $q->where('status', $status);
      })
      ->paginate(5)
      ->withQueryString();

    return view('dashboard.employees.index', [
      'employees' => $employees,
      'departments' => Department::select(['name', 'id'])->get(),
      'positions' => Position::select(['name', 'id'])->get(),
      'statuses' => StatusType::cases(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('dashboard.employees.create', [
      'positions' => Position::all(),
      'departments' => Department::all(),
      'statuses' => StatusType::cases(),
      'religions' => ReligionType::cases(),
      'genders' => GenderType::cases(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreEmployeeRequest $request)
  {
    $validated = $request->validated();
    $employee = Employee::create($validated);

    return redirect()
      ->route('employees.index')
      ->with('success', 'Employee created successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Employee $employee): View
  {
    return view('dashboard.employees.show', [
      'employee' => $employee,
      'matrix' => $employee->matrix(),
      'evaluations' => $employee->evaluations()->with('department', 'topic')->get(),
      'trainings' => $employee->trainings()->get(),
      'talents' => $employee->talents()->get(),
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Employee $employee)
  {
    return view('dashboard.employees.edit', [
      'employee' => $employee->load(['position', 'department']),
      'positions' => Position::all(),
      'departments' => Department::all(),
      'statuses' => StatusType::cases(),
      'religions' => ReligionType::cases(),
      'genders' => GenderType::cases(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateEmployeeRequest $request, Employee $employee)
  {
    $validated = $request->validated();
    $employee->update($validated);

    return redirect()
      ->route('employees.index', $employee)
      ->with('success', 'Employee updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Employee $employee)
  {
    $employee->delete();

    return redirect()
      ->route('employees.index')
      ->with('success', 'Employee deleted successfully!');
  }

  /**
   * Change employee evaluation score.
   */
  public function score(Request $request, Employee $employee)
  {
    $evaluations = $employee->evaluations;

    $validated = $request->validate([
      'scores' => ['required', 'array'],
      'scores.*' => [
        'required',
        'numeric',
        'min:0',
        function ($attribute, $value, $fail) use ($evaluations) {
          $id = Str::after($attribute, 'scores.');

          $evalution_ids = $evaluations->pluck('id')->toArray();
          if (!in_array($id, $evalution_ids)) $fail('The selected evaluation is invalid.');

          $evaluation = $evaluations->find($id);
          if ($value > $evaluation->target) $fail('The score must be less than or equal to the target score.');
        },
      ],
    ]);

    foreach ($validated['scores'] as $id => $score) {
      $employee->evaluations()->updateExistingPivot($id, [
        'score' => $score,
      ]);
    }

    return back()->with('success', 'Employee score updated successfully!');
  }
}
