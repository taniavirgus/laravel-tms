<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $trainings = [
      [
        'name' => 'Effective Communication Skills',
        'description' => 'A comprehensive workshop to enhance verbal and written communication for HR professionals.',
        'start_date' => '2025-07-01',
        'end_date' => '2025-07-03',
        'duration' => 3,
        'capacity' => 25,
        'department_id' => 1,
        'evaluation_id' => null,
      ],
      [
        'name' => 'Advanced Financial Analysis',
        'description' => 'In-depth training on financial modeling, forecasting, and analysis for finance staff.',
        'start_date' => '2025-07-10',
        'end_date' => '2025-07-12',
        'duration' => 3,
        'capacity' => 20,
        'department_id' => 2,
        'evaluation_id' => null,
      ],
      [
        'name' => 'Digital Marketing Strategies',
        'description' => 'Learn the latest digital marketing trends and tools to boost brand engagement.',
        'start_date' => '2025-07-15',
        'end_date' => '2025-07-17',
        'duration' => 3,
        'capacity' => 30,
        'department_id' => 3,
        'evaluation_id' => null,
      ],
      [
        'name' => 'Cybersecurity Essentials',
        'description' => 'Essential training on protecting company data and IT infrastructure from cyber threats.',
        'start_date' => '2025-07-20',
        'end_date' => '2025-07-22',
        'duration' => 3,
        'capacity' => 15,
        'department_id' => 4,
        'evaluation_id' => null,
      ],
      [
        'name' => 'Lean Operations Management',
        'description' => 'Improve operational efficiency and quality control using lean management principles.',
        'start_date' => '2025-07-25',
        'end_date' => '2025-07-27',
        'duration' => 3,
        'capacity' => 18,
        'department_id' => 5,
        'evaluation_id' => null,
      ],
    ];

    foreach ($trainings as $training) {
      Training::create($training);
    }
  }
}
