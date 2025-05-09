<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Evaluation;
use App\Models\User;

class EvaluationPolicy
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
  public function view(User $user, Evaluation $evaluation): bool
  {
    return true;
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->role == RoleType::PD;
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Evaluation $evaluation): bool
  {
    return $user->role == RoleType::PD;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Evaluation $evaluation): bool
  {
    return $user->role == RoleType::PD;
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Evaluation $evaluation): bool
  {
    return true;
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Evaluation $evaluation): bool
  {
    return true;
  }

  /**
   * Determine whether the user can assign employees to the evaluation.
   */
  public function assign(User $user, Evaluation $evaluation): bool
  {
    return $user->role == RoleType::PD;
  }

  /**
   * Determine whether the user can unassign employees from the evaluation.
   */
  public function unassign(User $user, Evaluation $evaluation): bool
  {
    return $user->role == RoleType::PD;
  }
}
