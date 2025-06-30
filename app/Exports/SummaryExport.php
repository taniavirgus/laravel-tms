<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SummaryExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    $employees = Employee::with('trainings', 'evaluations', 'feedback', 'department', 'position')
      ->get()
      ->map(function ($employee) {
        $employee->matrix = $employee->matrix();
        return $employee;
      });

    return $employees->map(function ($employee) {
      $employee->training_count = $employee->matrix->training_count;
      $employee->evaluation_count = $employee->matrix->evaluation_count;

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

  /**
   * @return array<string>
   */
  public function headings(): array
  {
    return [
      'id',
      'created_at',
      'updated_at',
      'name',
      'email',
      'phone',
      'address',
      'birthdate',
      'gender',
      'religion',
      'status',
      'department_id',
      'position_id',
      'unknown',
      'training_count',
      'evaluation_count',
      'feedback_score',
      'training_score',
      'evaluation_score',
      'performance_score',
      'potential_score',
      'average_score',
      'segment',
      'average_score',
      'average_potential',
      'average_performance',
    ];
  }
}
