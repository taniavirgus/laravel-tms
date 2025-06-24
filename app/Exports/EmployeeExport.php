<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Employee::all();
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
    ];
  }
}
