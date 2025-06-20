<?php

namespace App\Models;

use App\Traits\HasPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Feedback extends Model
{
  use HasPeriod;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'teamwork',
    'communication',
    'initiative',
    'problem_solving',
    'adaptability',
    'talent',
    'description',
    'employee_id',
    'period_id',
    'content'
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array<int, string>
   */
  protected $appends = ['average'];

  /**
   * Employee who is the feedback belongs to.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function employee(): BelongsTo
  {
    return $this->belongsTo(Employee::class);
  }

  /**
   * Get the average score of all feedback metrics.
   */
  protected function average(): Attribute
  {
    return Attribute::make(
      get: function () {
        $scores = [
          $this->teamwork,
          $this->communication,
          $this->initiative,
          $this->problem_solving,
          $this->adaptability,
          $this->talent
        ];

        return array_sum($scores) / count($scores);
      }
    );
  }
}
