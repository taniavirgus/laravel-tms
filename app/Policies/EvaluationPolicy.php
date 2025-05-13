<?php

namespace App\Policies;

use App\Enums\ApprovalType;
use App\Enums\RoleType;
use App\Models\Evaluation;
use App\Models\User;

class EvaluationPolicy
{
  /**
   * List of allowed roles for viewing evaluations.
   */
  private const ALLOWED_ROLES = [
    RoleType::MANAGER,
    RoleType::SUPERVISOR,
    RoleType::PD,
  ];

  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    return in_array($user->role, self::ALLOWED_ROLES);
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, Evaluation $evaluation): bool
  {
    return in_array($user->role, self::ALLOWED_ROLES);
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    return $user->role === RoleType::PD;
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Evaluation $evaluation): bool
  {
    return $user->role === RoleType::PD;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Evaluation $evaluation): bool
  {
    return $user->role === RoleType::PD;
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
    return $user->role === RoleType::PD && $evaluation->status === ApprovalType::APPROVED;
  }

  /**
   * Determine whether the user can unassign employees from the evaluation.
   */
  public function unassign(User $user, Evaluation $evaluation): bool
  {
    return $user->role === RoleType::PD && $evaluation->status === ApprovalType::APPROVED;
  }

  /**
   * Determine whether the user can change the approval status of the evaluation.
   */
  public function approval(User $user, Evaluation $evaluation): bool
  {
    return $user->role === RoleType::MANAGER || $user->role === RoleType::SUPERVISOR;
  }
}
