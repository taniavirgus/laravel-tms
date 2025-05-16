<?php

namespace App\Http\Controllers;

use App\Enums\StatusType;
use App\Models\Training;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Evaluation;
use App\Notifications\TrainingNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TrainingController extends Controller
{
  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
    $this->authorizeResource(Training::class);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');
    $status = $request->input('status');
    $department_id = $request->input('department_id');

    $trainings = Training::query()
      ->with(['department', 'evaluation'])
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
      })
      ->when($status, function ($q) use ($status) {
        $q->where('status', $status);
      })
      ->when($department_id, function ($q) use ($department_id) {
        $q->where('department_id', $department_id);
      })
      ->paginate(5)
      ->withQueryString();

    return view('dashboard.trainings.index', [
      'trainings' => $trainings,
      'departments' => Department::select(['name', 'id'])->get(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('dashboard.trainings.create', [
      'departments' => Department::select(['name', 'id'])->get(),
      'evaluations' => Evaluation::select(['name', 'id'])->get(),
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreTrainingRequest $request)
  {
    $validated = $request->validated();
    $training = Training::create($validated);

    return redirect()
      ->route('trainings.show', $training)
      ->with('success', 'Training created successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Training $training)
  {
    $assigned = $training->employees->load('department', 'position');
    $assigned_ids = $assigned->pluck('id')->toArray();

    $employees = Employee::with(['department', 'position'])
      ->where('department_id', $training->department_id)
      ->where('status', StatusType::ACTIVE->value)
      ->whereNotIn('id', $assigned_ids)
      ->get();

    return view('dashboard.trainings.show', [
      'training' => $training,
      'assigned' => $assigned,
      'employees' => $employees,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Training $training)
  {
    return view('dashboard.trainings.edit', [
      'training' => $training->load(['department', 'evaluation']),
      'departments' => Department::select(['name', 'id'])->get(),
      'evaluations' => Evaluation::select(['name', 'id'])->get(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateTrainingRequest $request, Training $training)
  {
    $validated = $request->validated();
    $training->update($validated);

    return redirect()
      ->route('trainings.show', $training)
      ->with('success', 'Training updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Training $training)
  {
    $training->delete();

    return redirect()
      ->route('trainings.index')
      ->with('success', 'Training deleted successfully.');
  }

  /**
   * Assign an employee to an training.
   */
  public function assign(Request $request, Training $training): RedirectResponse
  {
    $validated = $request->validate([
      'employee_id' => [
        'required',
        'exists:employees,id',
        Rule::unique('employee_trainings')->where(function ($query) use ($training) {
          return $query->where('training_id', $training->id);
        }),
      ],
    ]);

    $id = $validated['employee_id'];
    $training->employees()->attach($id, [
      'score' => 0,
      'email_sent' => false,
    ]);

    return back()->with('success', 'Employee assigned successfully!');
  }

  /**
   * Unassign an employee from an training.
   */
  public function unassign(Training $training, Employee $employee): RedirectResponse
  {
    $training->employees()->detach($employee->id);

    return back()->with('success', 'Employee unassigned successfully!');
  }

  /**
   * Notify employees about the training.
   */
  public function notify(Training $training): RedirectResponse
  {
    $training->notified = true;
    $training->save();

    $training->employees->each(function ($employee) use ($training) {
      $employee->notify(new TrainingNotification($training, $employee));
      $employee->pivot->email_sent = true;
      $employee->pivot->save();
    });

    return back()->with('success', 'Employees notified successfully!');
  }
}
