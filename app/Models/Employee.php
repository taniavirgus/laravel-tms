<?php

namespace App\Models;

use App\Enums\GenderType;
use App\Enums\ReligionType;
use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
  use HasFactory;

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
}
