<?php

namespace App\Policies;

use App\Enums\CompletionStatus;
use App\Enums\RoleType;
use App\Models\Training;
use App\Models\User;

class TrainingPolicy
{
  /**
   * List of allowed roles.
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
  public function view(User $user, Training $training): bool
  {
    return in_array($user->role, self::ALLOWED_ROLES);
  }

  /** 
   * Determine whether the user can export the model.
   */
  public function export(User $user): bool
  {
    return in_array($user->role, self::ALLOWED_ROLES);
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
  public function update(User $user, Training $training): bool
  {
    return $user->role == RoleType::PD && $training->status == CompletionStatus::UPCOMING;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Training $training): bool
  {
    return $user->role == RoleType::PD && $training->status == CompletionStatus::UPCOMING;
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Training $training): bool
  {
    return false;
  }

  /**
   * Determine whether the user can assign any training.
   */
  public function assignAny(User $user): bool
  {
    return $user->role == RoleType::PD;
  }

  /**
   * Determine whether the user can assign the employee to the training.
   */
  public function assign(User $user, Training $training): bool
  {
    return $user->role == RoleType::PD && $training->status == CompletionStatus::UPCOMING;
  }

  /**
   * Determine whether the user can unassign the employee from the training.
   */
  public function unassign(User $user, Training $training): bool
  {
    return $user->role == RoleType::PD && $training->status == CompletionStatus::UPCOMING;
  }

  /**
   * Determine whether the user can set scores for the training.
   */
  public function score(User $user, Training $training): bool
  {
    return $user->role == RoleType::PD && in_array($training->status, [
      CompletionStatus::FINALIZED,
      CompletionStatus::ONGOING,
      CompletionStatus::COMPLETED,
    ]);
  }

  /**
   * Determine whether the user can notify and locked the training.
   */
  public function notify(User $user, Training $training): bool
  {
    return $user->role == RoleType::PD && $training->status == CompletionStatus::UPCOMING;
  }

  /**
   * Determine wether the user can access the training material.
   */
  public function material(User $user, Training $training): bool
  {
    return in_array($user->role, self::ALLOWED_ROLES);
  }

  /**
   * Determine whether the user can upload the training material.
   */
  public function upload(User $user, Training $training): bool
  {
    return $user->role == RoleType::PD && in_array($training->status, [
      CompletionStatus::UPCOMING,
    ]);
  }

  /**
   * Determine whether the user can remove the attachment from the training material.
   */
  public function remove(User $user, Training $training): bool
  {
    return $user->role == RoleType::PD && in_array($training->status, [
      CompletionStatus::UPCOMING,
    ]);
  }
}
