<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTraining extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array<string, string>
   */
  protected $fillable = [
    'employee_id',
    'training_id',
    'email_sent',
    'score',
  ];

  /**
   * Get the employee that owns the training.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function employee()
  {
    return $this->belongsTo(Employee::class);
  }

  /**
   * Get the training that owns the employee.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function training()
  {
    return $this->belongsTo(Training::class);
  }
}
