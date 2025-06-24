<?php

namespace App\Exports;

use App\Models\Training;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrainingExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return Training::all();
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
      'description',
      'start_date',
      'end_date',
      'type',
      'assignment',
      'duration',
      'capacity',
    ];
  }
}
