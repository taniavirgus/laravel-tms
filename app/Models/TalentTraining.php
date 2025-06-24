<?php

namespace App\Models;

use App\Enums\CompletionStatus;
use App\Enums\SegmentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TalentTraining extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array<string, mixed>
   */
  protected $fillable = [
    'name',
    'description',
    'start_date',
    'end_date',
    'duration',
    'capacity',
    'notified',
    'segment',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected function casts(): array
  {
    return [
      'start_date' => 'date',
      'end_date' => 'date',
      'notified' => 'boolean',
      'segment' => SegmentType::class,
    ];
  }

  /**
   * Get the talent development's status attribute.
   *
   * @return string
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
   * Scope to filter talent developments by status.
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
      CompletionStatus::UPCOMING => $query->where('notified', false)->where('start_date', '>', now()),
      CompletionStatus::ONGOING => $query->where('start_date', '<=', now())->where('end_date', '>=', now())->where('notified', false),
    };
  }

  /**
   * The employees that are attending the talent development.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function employees(): BelongsToMany
  {
    return $this->belongsToMany(Employee::class, 'employee_talent_trainings')
      ->withPivot(
        'score',
        'email_sent',
        'notes'
      );
  }

  /**
   * Relationship with the Attachment model.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function attachments(): MorphMany
  {
    return $this->morphMany(Attachment::class, 'attachable');
  }
}
