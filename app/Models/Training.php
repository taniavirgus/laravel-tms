<?php

namespace App\Models;

use App\Enums\CompletionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Training extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'description',
    'start_date',
    'end_date',
    'duration',
    'capacity',
    'locked',
    'department_id',
    'evaluation_id',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
    'locked' => 'boolean',
  ];

  /**
   * Relationship with the Department model.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function department(): BelongsTo
  {
    return $this->belongsTo(Department::class);
  }

  /**
   * Relationship with the Evaluation model.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function evaluation(): BelongsTo
  {
    return $this->belongsTo(Evaluation::class)
      ->withDefault([
        'name' => 'No evaluation assigned',
      ]);
  }

  /**
   * Get the training's status attribute.
   *
   * @return \App\Enums\CompletionStatus
   */
  public function getStatusAttribute(): CompletionStatus
  {
    return match (true) {
      $this->end_date < now() => CompletionStatus::COMPLETED,
      $this->notified == true => CompletionStatus::FINALIZED,
      $this->start_date > now() => CompletionStatus::UPCOMING,
      default => CompletionStatus::ONGOING,
    };
  }

  /**
   * The employees that are attending the training.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function employees(): BelongsToMany
  {
    return $this->belongsToMany(Employee::class, 'employee_trainings')
      ->withPivot('score', 'email_sent')
      ->withTimestamps();
  }
}
