<?php

namespace App\Http\Controllers;

use App\Enums\CompletionStatus;
use App\Enums\SegmentType;
use App\Exports\TalentTrainingExport;
use App\Models\TalentTraining;
use App\Http\Requests\StoreTalentTrainingRequest;
use App\Http\Requests\UpdateTalentTrainingRequest;
use App\Models\Attachment;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Notifications\TalentTrainingNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Uri;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;

class TalentTrainingController extends Controller
{
  /**
   * Create a new controller instance.
   */
  public function __construct()
  {
    $this->authorizeResource(TalentTraining::class, 'talent');
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');
    $status = $request->input('status');
    $segment = $request->input('segment');

    $talents = TalentTraining::query()
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
      })
      ->when($status, function ($q) use ($status) {
        $q->withStatus($status);
      })
      ->when($segment, function ($q) use ($segment) {
        $q->where('segment', $segment);
      })
      ->orderBy('start_date', 'asc')
      ->paginate(5)
      ->withQueryString();

    return view('dashboard.talents.index', [
      'talents' => $talents,
      'segments' => SegmentType::cases(),
      'statuses' => CompletionStatus::cases(),
    ]);
  }

  /** 
   * Export the talent trainings into csv file.
   */
  public function export(Request $request)
  {
    return Excel::download(new TalentTrainingExport, 'talents.csv', ExcelFormat::CSV);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Request $request)
  {
    $segment = $request->input('segment');
    if ($segment) $segment = SegmentType::tryFrom($segment);

    $segments = SegmentType::cases();

    return view('dashboard.talents.create', [
      'segments' => $segments,
      'segment' => $segment,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreTalentTrainingRequest $request)
  {
    $validated = $request->validated();
    $talent = TalentTraining::create($validated);

    return redirect()
      ->route('talents.show', $talent)
      ->with('success', 'Talent training created successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request, TalentTraining $talent)
  {
    $search = $request->input('search');
    $position_id = $request->input('position_id');
    $department_id = $request->input('department_id');

    $assigned = $talent->employees()
      ->with('department', 'position')
      ->get();

    $employees = Employee::with('trainings', 'evaluations', 'feedback')
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')
          ->orWhere('email', 'like', '%' . $search . '%');
      })
      ->when($position_id, function ($q) use ($position_id) {
        $q->where('position_id', $position_id);
      })
      ->when($department_id, function ($q) use ($department_id) {
        $q->where('department_id', $department_id);
      })
      ->whereNotIn('id', $assigned->pluck('id'))
      ->get()
      ->map(function ($employee) {
        $employee->matrix = $employee->matrix();
        return $employee;
      });

    $employees = $employees
      ->load('department', 'position')
      ->filter(fn($employee) => $employee->matrix->segment === $talent->segment);

    $employees = new LengthAwarePaginator(
      $employees->forPage(request()->get('page', 1), request()->get('per_page', 5)),
      $employees->count(),
      request()->get('per_page', 5),
      request()->get('page', 1),
      ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('dashboard.talents.show', [
      'talent' => $talent,
      'departments' => Department::select(['name', 'id'])->get(),
      'positions' => Position::select(['name', 'id'])->get(),
      'assigned' => $assigned,
      'employees' => $employees,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(TalentTraining $talent)
  {
    return view('dashboard.talents.edit', [
      'talent' => $talent,
      'segments' => SegmentType::cases(),
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateTalentTrainingRequest $request, TalentTraining $talent)
  {
    $validated = $request->validated();
    $talent->update($validated);

    return redirect()
      ->route('talents.show', $talent)
      ->with('success', 'Talent training updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(TalentTraining $talent)
  {
    $talent->delete();

    return redirect()
      ->route('talents.index')
      ->with('success', 'Talent training deleted successfully.');
  }

  /**
   * Assign an employee to an talent training.
   */
  public function assign(Request $request, TalentTraining $talent): RedirectResponse
  {
    $validated = $request->validate([
      'employee_id' => [
        'required',
        'exists:employees,id',
        Rule::unique('employee_talent_trainings')->where(function ($query) use ($talent) {
          return $query->where('talent_training_id', $talent->id);
        }),
      ],
    ]);

    $id = $validated['employee_id'];
    $employee = Employee::findOrFail($id)->load('trainings', 'evaluations', 'feedback');
    $employee->matrix = $employee->matrix();

    if ($employee->matrix->segment !== $talent->segment) return back()->with('error', 'Employee not assigned to this talent training!');
    $talent->employees()->attach($id, [
      'score' => 0,
      'email_sent' => false,
      'notes' => 'No notes provided',
    ]);

    return back()->with('success', 'Employee assigned successfully!');
  }

  /**
   * Unassign an employee from an talent training.
   */
  public function unassign(TalentTraining $talent, Employee $employee): RedirectResponse
  {
    $talent->employees()->detach($employee->id);
    return back()->with('success', 'Employee unassigned successfully!');
  }

  /**
   * Notify employees about the talent training.
   */
  public function notify(TalentTraining $talent): RedirectResponse
  {
    if ($talent->employees->isEmpty()) return back()->with('warning', 'No employees assigned to this talent training yet!');

    $talent->notified = true;
    $talent->save();

    $talent->employees->each(function ($employee) use ($talent) {
      $employee->notify(new TalentTrainingNotification($talent, $employee));
      $employee->pivot->email_sent = true;
      $employee->pivot->save();
    });

    return back()->with('success', 'Employees notified successfully!');
  }

  /**
   * Change employee score for a given talent training.
   */
  public function score(Request $request, TalentTraining $talent, Employee $employee): RedirectResponse
  {
    if (!$talent->employees->contains($employee)) return back()->with('error', 'Employee not assigned to this talent training!');

    $validated = $request->validate([
      'score' => ['required', 'integer', 'min:0', 'max:100'],
      'notes' => ['nullable', 'string'],
    ]);

    $talent->employees()->updateExistingPivot($employee->id, $validated);

    return back()->with('success', "Employee score updated successfully!");
  }

  /**
   * Display the training materials.
   */
  public function material(Request $request, TalentTraining $talent)
  {
    $assigned = $talent->employees()
      ->with('department', 'position')
      ->get();

    return view('dashboard.talents.material', [
      'talent' => $talent,
      'assigned' => $assigned,
      'attachments' => $talent->attachments,
    ]);
  }

  /**
   * Upload a talent material.
   */
  public function upload(Request $request, TalentTraining $talent)
  {
    $request->validate([
      'files' => ['required', 'array'],
      'files.*' => [
        'required',
        'file',
        'max:6144',
        'mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp'
      ],
    ]);

    $files = $request->file('files');
    $uploaded = collect($files)->map(function ($file) {
      $url = $file->store('uploads', 'public');

      return [
        'url' => asset($url),
        'size' => $file->getSize(),
        'filename' => $file->getClientOriginalName(),
        'mime_type' => $file->getMimeType(),
      ];
    });

    $talent->attachments()->createMany($uploaded);

    return redirect()
      ->route('talents.material', $talent)
      ->with('success', 'Training material uploaded successfully!');
  }

  /**
   * Remove a talent material.
   */
  public function remove(TalentTraining $talent, Attachment $attachment)
  {
    $uri = Uri::of($attachment->url);
    $path = $uri->path();
    $exist = Storage::disk('public')->exists($path);
    if ($exist) Storage::disk('public')->delete($path);

    $attachment->delete();

    return redirect()
      ->route('talents.material', $talent)
      ->with('success', 'Training material removed successfully!');
  }
}
