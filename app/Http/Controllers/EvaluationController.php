<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalType;
use App\Enums\StatusType;
use App\Models\Employee;
use App\Models\Evaluation;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\Department;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EvaluationController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->authorizeResource(Evaluation::class);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');
    $department_id = $request->input('department_id');
    $topic_id = $request->input('topic_id');

    $evaluations = Evaluation::query()
      ->with(['department', 'topic'])
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
      })
      ->when($department_id, function ($q) use ($department_id) {
        $q->where('department_id', $department_id);
      })
      ->when($topic_id, function ($q) use ($topic_id) {
        $q->where('topic_id', $topic_id);
      })
      ->paginate(5)
      ->withQueryString();

    return view('dashboard.evaluations.index', [
      'evaluations' => $evaluations,
      'departments' => Department::select(['name', 'id'])->get(),
      'topics' => Topic::select(['name', 'id'])->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    return view('dashboard.evaluations.create', [
      'departments' => Department::all(),
      'topics' => Topic::all(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreEvaluationRequest $request): RedirectResponse
  {
    $validated = $request->validated();
    $evaluation = Evaluation::create($validated);

    return redirect()
      ->route('evaluations.show', $evaluation->id)
      ->with('success', 'Evaluation created successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Evaluation $evaluation): View
  {
    $evaluation->load([
      'department',
      'topic'
    ]);

    $assigned = $evaluation->employees->load('department', 'position');
    $assigned_ids = $assigned->pluck('id')->toArray();

    $employees = Employee::with(['department', 'position'])
      ->where('department_id', $evaluation->department_id)
      ->where('status', StatusType::ACTIVE->value)
      ->whereNotIn('id', $assigned_ids)
      ->get();

    return view('dashboard.evaluations.show', [
      'evaluation' => $evaluation,
      'assigned' => $assigned,
      'employees' => $employees,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Evaluation $evaluation): View
  {
    return view('dashboard.evaluations.edit', [
      'evaluation' => $evaluation->load(['department', 'topic']),
      'departments' => Department::all(),
      'topics' => Topic::all(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateEvaluationRequest $request, Evaluation $evaluation): RedirectResponse
  {
    $validated = $request->validated();
    $department = $evaluation->department;
    $evaluation->update($validated);

    if ($department->id != $evaluation->department_id) $evaluation->employees()->detach();

    return redirect()
      ->route('evaluations.show', $evaluation->id)
      ->with('success', 'Evaluation updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Evaluation $evaluation): RedirectResponse
  {
    $evaluation->delete();

    return redirect()
      ->route('evaluations.index')
      ->with('success', 'Evaluation deleted successfully!');
  }

  /**
   * Assign an employee to an evaluation.
   */
  public function assign(Request $request, Evaluation $evaluation): RedirectResponse
  {
    $validated = $request->validate([
      'employee_id' => [
        'required',
        'exists:employees,id',
        Rule::unique('employee_evaluations')->where(function ($query) use ($evaluation) {
          return $query->where('evaluation_id', $evaluation->id);
        }),
      ],
    ]);

    $id = $validated['employee_id'];
    $evaluation->employees()->attach($id, [
      'score' => 0
    ]);

    return back()->with('success', 'Employee assigned successfully!');
  }

  /**
   * Unassign an employee from an evaluation.
   */
  public function unassign(Evaluation $evaluation, Employee $employee): RedirectResponse
  {
    $evaluation->employees()->detach($employee->id);

    return back()->with('success', 'Employee unassigned successfully!');
  }

  /**
   * Change the approval status of an evaluation.
   */
  public function approval(Request $request, Evaluation $evaluation): RedirectResponse
  {
    $validated = $request->validate([
      'status' => [
        'required',
        'string',
        Rule::in(array_map(fn($type) => $type->value, ApprovalType::cases())),
      ],
    ]);

    $status = $validated['status'];
    $evaluation->status = ApprovalType::from($status);
    $evaluation->save();

    if ($status !== ApprovalType::APPROVED->value) $evaluation->employees()->detach();

    return back()->with('success', "Evaluation status updated successfully!");
  }
}
