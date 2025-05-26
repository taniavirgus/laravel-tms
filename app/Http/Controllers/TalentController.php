<?php

namespace App\Http\Controllers;

use App\Enums\TalentSegmentType;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TalentController extends Controller
{
  /**
   * Calculate the potential of an employee.
   */
  protected function getEmployeeMatrix(): Collection
  {
    return Employee::query()
      ->with(['feedback', 'trainings', 'evaluations', 'position', 'department'])
      ->withCount('trainings')
      ->get()
      ->each(function ($employee) {
        $feedback = $employee->feedback->average;
        $training = $employee->trainings->avg('pivot.score');

        $employee->potential = ($training + $feedback) / 2;
        $employee->performance = $employee->evaluations->map(function ($evaluation) {
          return $evaluation->pivot->score / $evaluation->target * 100;
        })->avg() ?? 0;

        $employee->segment = TalentSegmentType::getSegment($employee->potential, $employee->performance);
      });
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $employees = $this->getEmployeeMatrix();

    $segments = collect(TalentSegmentType::cases())->map(function ($type) use ($employees) {
      return (object) [
        'type' => $type,
        'count' => $employees->filter(fn($item) => $item->segment === $type)->count(),
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
    $type = TalentSegmentType::from($segment);
    $employees = $this->getEmployeeMatrix()->filter(fn($emp) => $emp->segment === $type);

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
