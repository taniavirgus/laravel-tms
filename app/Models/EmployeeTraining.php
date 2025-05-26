<?php

namespace App\Models;

use App\Traits\HasPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeTraining extends Model
{
  use HasPeriod;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<string, string>
   */
  protected $fillable = [
    'employee_id',
    'training_id',
    'period_id',
    'score'
  ];

  /**
   * Get the employee that owns the training.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function employee(): BelongsTo
  {
    return $this->belongsTo(Employee::class);
  }

  /**
   * Get the training that owns the employee.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function training(): BelongsTo
  {
    return $this->belongsTo(Training::class);
  }
}
