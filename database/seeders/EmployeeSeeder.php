<?php

namespace Database\Seeders;

use App\Enums\GenderType;
use App\Enums\ReligionType;
use App\Enums\StatusType;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

    for ($i = 0; $i < 20; $i++) {
      Employee::factory()->create([
        'department_id' => $departments->random()->id,
        'position_id' => $positions->random()->id,
      ]);
    }
  }
}
