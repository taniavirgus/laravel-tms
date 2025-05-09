<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeEvaluation extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array<string, string>
   */
  protected $fillable = [
    'employee_id',
    'evaluation_id',
    'score',
  ];

  /**
   * Get the employee that owns the evaluation.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function employee(): BelongsTo
  {
    return $this->belongsTo(Employee::class);
  }

  /**
   * Get the evaluation that owns the employee.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function evaluation(): BelongsTo
  {
    return $this->belongsTo(Evaluation::class);
  }
}
