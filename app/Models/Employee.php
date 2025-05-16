<?php

namespace App\Models;

use App\Enums\GenderType;
use App\Enums\ReligionType;
use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'phone',
    'address',
    'birthdate',
    'gender',
    'religion',
    'status',
    'department_id',
    'position_id',
  ];

  /**
   * The attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'birthdate' =>  'date',
      'status' => StatusType::class,
      'religion' => ReligionType::class,
      'gender' => GenderType::class,
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
  public function position(): BelongsTo
  {
    return $this->belongsTo(Position::class);
  }

  /**
   * The evaluations that belong to the employee.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function evaluations(): BelongsToMany
  {
    return $this->belongsToMany(Evaluation::class, 'employee_evaluations')
      ->withPivot('score')
      ->withTimestamps();
  }

  /**
   * The feedback that belong to the employee.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function feedback(): HasOne
  {
    return $this->hasOne(Feedback::class)
      ->withDefault([
        'teamwork' => 0,
        'communication' => 0,
        'initiative' => 0,
        'problem_solving' => 0,
        'adaptability' => 0,
        'leadership' => 0,
        'description' => 'No feedback available',
      ]);
  }

  /**
   * The trainings that belong to the employee.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */

  public function trainings(): BelongsToMany
  {
    return $this->belongsToMany(Training::class, 'employee_trainings')
      ->withPivot('score', 'email_sent')
      ->withTimestamps();
  }
}
