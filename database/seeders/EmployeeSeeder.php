<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $departments = Department::all();
    $positions = Position::all();

    foreach (range(1, 100) as $i) {
      Employee::factory()->create([
        'department_id' => $departments->random()->id,
        'position_id' => $positions->random()->id,
      ]);
    }
  }
}
