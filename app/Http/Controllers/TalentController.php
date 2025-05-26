<?php

namespace App\Http\Controllers;

use App\Enums\SegmentType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TalentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $employees = Employee::with('trainings', 'evaluations', 'feedback')->get()->map(function ($employee) {
      $employee->matrix = $employee->matrix();
      return $employee;
    });

    $segments = collect(SegmentType::cases())->map(function ($type) use ($employees) {
      return (object) [
        'type' => $type,
        'count' => $employees->filter(fn($employee) => $employee->matrix->segment === $type)->count(),
      ];
    })->values();

    return view('dashboard.talents.index', [
      'segments' => $segments,
      'totals' => $employees->count(),
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(string $segment): View
  {
    $type = SegmentType::from($segment);
    $employees = Employee::with('trainings', 'evaluations', 'feedback')->get()->map(function ($employee) {
      $employee->matrix = $employee->matrix();
      return $employee;
    });

    $employees = $employees->load('department', 'position')->filter(fn($employee) => $employee->matrix->segment === $type)->sortByDesc('matrix.average_score');
    return view('dashboard.talents.show', [
      'employees' => $employees,
      'segment' => $type,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Employee $employee)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Employee $employee)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Employee $employee)
  {
    //
  }
}
