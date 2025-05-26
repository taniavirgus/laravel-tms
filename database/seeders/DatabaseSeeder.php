<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      PeriodSeeder::class,
      UserSeeder::class,
      DepartmentSeeder::class,
      PositionSeeder::class,
      EmployeeSeeder::class,
      TopicSeeder::class,
      EvaluationSeeder::class,
      TrainingSeeder::class,
    ]);
  }
}
