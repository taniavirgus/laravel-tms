<?php

namespace App\Models;

use App\Enums\CompletionStatus;
use App\Enums\TrainingType;
use App\Interfaces\WithPeriodPivot;
use App\Traits\HasPeriodRelation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\AssignmentType;

class Training extends Model implements WithPeriodPivot
{
  use HasPeriodRelation;

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
    'type',
    'assignment',
    'duration',
    'capacity',
    'notified',
    'evaluation_id',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'start_date' => 'date',
      'end_date' => 'date',
      'notified' => 'boolean',
      'type' => TrainingType::class,
      'assignment' => AssignmentType::class,
    ];
  }

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
   * Scope to filter trainings by status.
   * 
   * @param \Illuminate\Database\Eloquent\Builder $query
   * @param string $status
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeWithStatus($query, string $status)
  {
    $status = CompletionStatus::tryFrom($status);

    return match ($status) {
      CompletionStatus::COMPLETED => $query->where('end_date', '<', now()),
      CompletionStatus::FINALIZED => $query->where('notified', true)->where('end_date', '>=', now()),
      CompletionStatus::UPCOMING => $query->where('start_date', '>', now()),
      CompletionStatus::ONGOING => $query->where('start_date', '<=', now())->where('end_date', '>=', now())->where('notified', false),
    };
  }

  /**
   * The employees that are attending the training.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function employees(): BelongsToMany
  {
    return $this->belongsToManyWithPeriod(Employee::class, 'employee_trainings')
      ->withPivot('score', 'email_sent');
  }

  /**
   * Relationship with the Department model.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function departments(): BelongsToMany
  {
    return $this->belongsToMany(Department::class);
  }
}
