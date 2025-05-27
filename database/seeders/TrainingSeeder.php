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
      ],
      [
        'name' => 'Advanced Financial Analysis',
        'description' => 'In-depth training on financial modeling, forecasting, and analysis for finance staff.',
        'start_date' => '2025-07-10',
        'end_date' => '2025-07-12',
        'duration' => 3,
        'capacity' => 20,
      ],
      [
        'name' => 'Digital Marketing Strategies',
        'description' => 'Learn the latest digital marketing trends and tools to boost brand engagement.',
        'start_date' => '2025-07-15',
        'end_date' => '2025-07-17',
        'duration' => 3,
        'capacity' => 30,
      ],
      [
        'name' => 'Cybersecurity Essentials',
        'description' => 'Essential training on protecting company data and IT infrastructure from cyber threats.',
        'start_date' => '2025-07-20',
        'end_date' => '2025-07-22',
        'duration' => 3,
        'capacity' => 15,
      ],
      [
        'name' => 'Lean Operations Management',
        'description' => 'Improve operational efficiency and quality control using lean management principles.',
        'start_date' => '2025-07-25',
        'end_date' => '2025-07-27',
        'duration' => 3,
        'capacity' => 18,
      ],
    ];

    foreach ($trainings as $training) {
      Training::create($training);
    }
  }
}
