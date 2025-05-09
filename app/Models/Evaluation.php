<?php

namespace App\Models;

use App\Enums\ApprovalType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Evaluation extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'description',
    'point',
    'target',
    'weight',
    'status',
    'department_id',
    'topic_id',
  ];

  /**
   * The attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'status' => ApprovalType::class,
    ];
  }

  /**
   * Relationship with between model and other model.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function department(): BelongsTo
  {
    return $this->belongsTo(Department::class);
  }

  /**
   * Relationship with between model and other model.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function topic(): BelongsTo
  {
    return $this->belongsTo(Topic::class);
  }

  /**
   * The employees that belong to the evaluation.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function employees(): BelongsToMany
  {
    return $this->belongsToMany(Employee::class, 'employee_evaluations')
      ->withPivot('score')
      ->withTimestamps();
  }
}
