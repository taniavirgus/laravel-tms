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

    for ($i = 0; $i < 40; $i++) {
      Employee::factory()->create([
        'department_id' => $departments->random()->id,
        'position_id' => $positions->random()->id,
      ]);
    }
  }
}
