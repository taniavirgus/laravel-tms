<?php

namespace App\Exports;

use App\Models\TalentTraining;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TalentTrainingExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return TalentTraining::all();
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
      'duration',
      'segment',
    ];
  }
}
