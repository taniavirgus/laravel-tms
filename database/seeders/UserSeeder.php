<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::factory()->create([
      'name' => 'Administrator',
      'email' => 'sysadmin@example.com',
      'role' => RoleType::SYSADMIN->value,
    ]);

    User::factory()->create([
      'name' => 'User Manager',
      'email' => 'manager@example.com',
      'role' => RoleType::MANAGER->value,
    ]);

    User::factory()->create([
      'name' => 'User Supervisor',
      'email' => 'supervisor@example.com',
      'role' => RoleType::SUPERVISOR->value,
    ]);

    User::factory()->create([
      'name' => 'User People Dev',
      'email' => 'peopledev@example.com',
      'role' => RoleType::PD->value,
    ]);
  }
}
