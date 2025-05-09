<?php

namespace Database\Factories;

use App\Enums\GenderType;
use App\Enums\ReligionType;
use App\Enums\StatusType;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'name' => fake()->name(),
      'email' => fake()->unique()->safeEmail(),
      'phone' => fake()->phoneNumber(),
      'address' => fake()->address(),
      'birthdate' => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
      'gender' => fake()->randomElement(array_column(GenderType::cases(), 'value')),
      'religion' => fake()->randomElement(array_column(ReligionType::cases(), 'value')),
      'status' => fake()->randomElement([
        StatusType::ACTIVE->value,
        StatusType::ACTIVE->value,
        StatusType::ACTIVE->value,
        StatusType::ACTIVE->value,
        StatusType::INACTIVE->value,
      ]),
    ];
  }

  /**
   * Indicate that the employee is active.
   */
  public function active(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => StatusType::ACTIVE->value,
    ]);
  }

  /**
   * Indicate that the employee is inactive.
   */
  public function inactive(): static
  {
    return $this->state(fn(array $attributes) => [
      'status' => StatusType::INACTIVE->value,
    ]);
  }

  /**
   * Set a specific department for the employee.
   */
  public function inDepartment(Department $department): static
  {
    return $this->state(fn(array $attributes) => [
      'department_id' => $department->id,
    ]);
  }

  /**
   * Set a specific position for the employee.
   */
  public function withPosition(Position $position): static
  {
    return $this->state(fn(array $attributes) => [
      'position_id' => $position->id,
    ]);
  }
}
