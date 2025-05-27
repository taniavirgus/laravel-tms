<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Period;
use App\Models\User;

class PeriodPolicy
{
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
  public function view(User $user, Period $period): bool
  {
    return true;
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->role == RoleType::SYSADMIN;
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Period $period): bool
  {
    return $user->role == RoleType::SYSADMIN;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Period $period): bool
  {
    return $user->role == RoleType::SYSADMIN;
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Period $period): bool
  {
    return false;
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Period $period): bool
  {
    return false;
  }

  /**
   * Determine whether the user can switch the model.
   */
  public function switch(User $user): bool
  {
    return true;
  }
}
