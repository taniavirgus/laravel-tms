<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
  /**
   * List of allowed roles for the employee policy.
   * @var array
   */
  private array $allowed = [
    RoleType::SYSADMIN,
    RoleType::PD,
  ];

  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return true;
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, Employee $employee): bool
  {
    return true;
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return in_array($user->role, $this->allowed);
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Employee $employee): bool
  {
    return in_array($user->role, $this->allowed);
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Employee $employee): bool
  {
    return in_array($user->role, $this->allowed);
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Employee $employee): bool
  {
    return false;
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Employee $employee): bool
  {
    return false;
  }
}
