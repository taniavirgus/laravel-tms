<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\Department;
use App\Models\Evaluation;
use Illuminate\Http\Request;
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
    $department_id = $request->input('department_id');

    $trainings = Training::query()
      ->with(['department', 'evaluation'])
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%');
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
    return view('dashboard.trainings.show', [
      'training' => $training->load(['department', 'evaluation']),
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
}
