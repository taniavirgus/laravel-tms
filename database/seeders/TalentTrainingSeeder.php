<?php

namespace Database\Seeders;

use App\Enums\SegmentType;
use App\Models\TalentTraining;
use Illuminate\Database\Seeder;

class TalentTrainingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $talents = [
      [
        'name' => 'Talent Training Test',
        'description' => 'Talent training for employees',
        'start_date' => '2025-06-01',
        'end_date' => '2025-08-03',
        'duration' => 3,
        'segment' => SegmentType::HIGH_POTENTIAL,
      ],
      [
        'name' => 'Another Talent Training Test',
        'description' => 'Talent training for employees',
        'start_date' => '2025-07-01',
        'end_date' => '2025-08-03',
        'duration' => 3,
        'segment' => SegmentType::HIGH_PERFORMER,
      ],
      [
        'name' => 'Yet Another Talent Training Test',
        'description' => 'Talent training for employees',
        'start_date' => '2025-08-01',
        'end_date' => '2025-09-03',
        'duration' => 3,
        'segment' => SegmentType::HIGH_POTENTIAL,
      ],
    ];

    foreach ($talents as $talent) {
      TalentTraining::create($talent);
    }
  }
}
