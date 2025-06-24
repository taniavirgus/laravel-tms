<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;

class SummaryExport implements FromCollection
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    $employees = Employee::with('trainings', 'evaluations', 'feedback')->get()->map(function ($employee) {
      $employee->matrix = $employee->matrix();
      return $employee;
    });

    return $employees->map(function ($employee) {
      $employee->feedback_score = $employee->matrix->feedback_score;
      $employee->training_score = $employee->matrix->training_score;
      $employee->evaluation_score = $employee->matrix->evaluation_score;
      $employee->performance_score = $employee->matrix->performance_score;
      $employee->potential_score = $employee->matrix->potential_score;
      $employee->average_score = $employee->matrix->average_score;
      $employee->segment = $employee->matrix->segment->label();

      $employee->average_score = $employee->matrix->average_score;
      $employee->average_potential = $employee->matrix->potential_score;
      $employee->average_performance = $employee->matrix->performance_score;
      $employee->matrix = null;

      return $employee;
    });
  }
}
