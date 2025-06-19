<?php

namespace App\Http\Controllers;

use App\Enums\SegmentType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class TalentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): View
  {
    $employees = Employee::with('trainings', 'evaluations', 'feedback')
      ->get()
      ->map(function ($employee) {
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

    $employees = Employee::with('trainings', 'evaluations', 'feedback')
      ->get()
      ->map(function ($employee) {
        $employee->matrix = $employee->matrix();
        return $employee;
      });

    $employees = $employees
      ->load('department', 'position')
      ->filter(fn($employee) => $employee->matrix->segment === $type)
      ->sortByDesc('matrix.average_score');

    $employees = new LengthAwarePaginator(
      $employees->forPage(request()->get('page', 1), request()->get('per_page', 5)),
      $employees->count(),
      request()->get('per_page', 5),
      request()->get('page', 1),
      ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('dashboard.talents.show', [
      'employees' => $employees,
      'segment' => $type,
    ]);
  }
}
