<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
  /**
   * run the database seeds
   */
  public function run(): void
  {
    for ($i = 0; $i < 100; $i++) {
      $department = rand(1, 5);
      $position = match ($department) {
        1 => rand(1, 2),
        2 => rand(3, 4),
        3 => rand(5, 6),
        4 => rand(7, 8),
        5 => rand(9, 10),
      };

      Employee::factory()->create([
        'department_id' => $department,
        'position_id' => $position,
      ]);
    }
  }
}
