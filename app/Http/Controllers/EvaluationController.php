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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Illuminate\Support\Str;

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
   * Show the summary of the evaluation.
   */
  public function summary(Request $request): View
  {
    $department_id = $request->input('department_id');
    $topic_id = $request->input('topic_id');

    $evaluations_query = Evaluation::with(['department', 'topic', 'employees'])
      ->when($department_id, function ($q) use ($department_id) {
        $q->where('department_id', $department_id);
      })
      ->when($topic_id, function ($q) use ($topic_id) {
        $q->where('topic_id', $topic_id);
      });

    $evaluations = $evaluations_query->get();
    $evaluation_count = $evaluations->count();
    $average_score = 0;
    $employees_count = 0;

    if ($evaluation_count > 0) {
      $evaluation_ids = $evaluations->pluck('id')->toArray();
      $score_data = DB::table('employee_evaluations')
        ->join('evaluations', 'evaluations.id', '=', 'employee_evaluations.evaluation_id')
        ->whereIn('evaluation_id', $evaluation_ids)
        ->selectRaw('
          AVG((CAST(employee_evaluations.score AS REAL) / CAST(evaluations.target AS REAL)) * 100) as average_score, 
          COUNT(DISTINCT employee_id) as unique_employees, 
          COUNT(*) as total_records
        ')
        ->first();

      $average_score = $score_data->average_score ?? 0;
      $employees_count = $score_data->unique_employees ?? 0;
    }

    $total_employees = Employee::count();
    $completion_rate = $total_employees > 0 ? round(($employees_count / $total_employees) * 100) : 0;

    $department_data = collect();
    $departments = Department::get();

    if ($evaluation_count > 0) {
      $evaluation_ids = $evaluations->pluck('id')->toArray();
      $department_scores = DB::table('employee_evaluations')
        ->join('evaluations', 'evaluations.id', '=', 'employee_evaluations.evaluation_id')
        ->whereIn('evaluation_id', $evaluation_ids)
        ->groupBy('evaluations.department_id')
        ->select(
          'evaluations.department_id',
          DB::raw('AVG((CAST(employee_evaluations.score AS REAL) / CAST(evaluations.target AS REAL)) * 100) as average_score')
        )
        ->get()
        ->keyBy('department_id');
    }

    foreach ($departments as $department) {
      $department_data->push([
        'name' => $department->name,
        'average_score' => $evaluation_count > 0 ? ($department_scores[$department->id]->average_score ?? 0) : 0
      ]);
    }

    $department_names = $department_data->pluck('name')->toArray();
    $department_scores = $department_data->pluck('average_score')->toArray();

    $topic_data = collect();
    $topics = Topic::get();

    if ($evaluation_count > 0) {
      $evaluation_ids = $evaluations->pluck('id')->toArray();
      $topic_scores = DB::table('employee_evaluations')
        ->join('evaluations', 'evaluations.id', '=', 'employee_evaluations.evaluation_id')
        ->whereIn('evaluation_id', $evaluation_ids)
        ->groupBy('evaluations.topic_id')
        ->select(
          'evaluations.topic_id',
          DB::raw('AVG((CAST(employee_evaluations.score AS REAL) / CAST(evaluations.target AS REAL)) * 100) as average_score')
        )
        ->get()
        ->keyBy('topic_id');
    }

    foreach ($topics as $topic) {
      $topic_data->push([
        'name' => $topic->name,
        'average_score' => $evaluation_count > 0 ? ($topic_scores[$topic->id]->average_score ?? 0) : 0
      ]);
    }

    $topic_names = $topic_data->pluck('name')->toArray();
    $topic_scores = $topic_data->pluck('average_score')->toArray();

    $top_performers = Employee::select('employees.*')
      ->join('employee_evaluations', 'employees.id', '=', 'employee_evaluations.employee_id')
      ->join('evaluations', 'evaluations.id', '=', 'employee_evaluations.evaluation_id')
      ->with(['department', 'position'])
      ->groupBy('employees.id')
      ->selectRaw('AVG((CAST(employee_evaluations.score AS REAL) / CAST(evaluations.target AS REAL)) * 100) as average_score')
      ->selectRaw('COUNT(DISTINCT evaluations.id) as evaluations_count')
      ->orderByDesc('average_score')
      ->when($department_id, function ($q) use ($department_id) {
        $q->where('employees.department_id', $department_id);
      })
      ->when($topic_id, function ($q) use ($topic_id) {
        $q->where('evaluations.topic_id', $topic_id);
      })
      ->paginate(5)
      ->withQueryString();

    return view('dashboard.evaluations.summary', [
      'evaluations' => $evaluations,
      'departments' => $departments,
      'topics' => $topics,
      'average_score' => $average_score,
      'evaluation_count' => $evaluation_count,
      'employees_count' => $employees_count,
      'completion_rate' => $completion_rate,
      'department_names' => $department_names,
      'department_scores' => $department_scores,
      'topic_names' => $topic_names,
      'topic_scores' => $topic_scores,
      'top_performers' => $top_performers,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    return view('dashboard.evaluations.create', [
      'departments' => Department::select(['name', 'id'])->get(),
      'topics' => Topic::select(['name', 'id'])->get(),
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
      ->route('evaluations.show', $evaluation)
      ->with('success', 'Evaluation created successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Evaluation $evaluation): View
  {
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
      ->route('evaluations.show', $evaluation)
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
        new Enum(ApprovalType::class),
      ],
    ]);

    $status = $validated['status'];
    $evaluation->status = ApprovalType::from($status);
    $evaluation->save();

    if ($status !== ApprovalType::APPROVED->value) $evaluation->employees()->detach();

    return back()->with('success', "Evaluation status updated successfully!");
  }

  /**
   * Change employee score for a given evaluation.
   */
  public function score(Request $request, Evaluation $evaluation): RedirectResponse
  {
    $employee_ids = $evaluation->employees->pluck('id')->toArray();

    $validated = $request->validate([
      'scores' => ['required', 'array'],
      'scores.*' => [
        'required',
        'integer',
        'between:0,' . $evaluation->target,
        function ($attribute, $value, $fail) use ($employee_ids) {
          $id = Str::after($attribute, 'scores.');
          if (!in_array($id, $employee_ids)) $fail("Employee not assigned to this evaluation!");
        }
      ],
    ]);

    foreach ($validated['scores'] as $id => $score) {
      $evaluation->employees()->updateExistingPivot($id, [
        'score' => $score
      ]);
    }

    return back()->with('success', "Employee score updated successfully!");
  }
}
