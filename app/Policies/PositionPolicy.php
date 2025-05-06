<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Position;
use App\Models\User;

class PositionPolicy
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
  public function view(User $user, Position $position): bool
  {
    return true;
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->role === RoleType::SYSADMIN;
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Position $position): bool
  {
    return $user->role === RoleType::SYSADMIN;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Position $position): bool
  {
    return $user->role === RoleType::SYSADMIN;
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Position $position): bool
  {
    return false;
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Position $position): bool
  {
    return false;
  }
}
