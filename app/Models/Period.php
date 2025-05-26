<?php

namespace App\Models;

use App\Enums\SemesterType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Period extends Model
{
  /**
   * fillable attributes
   * 
   * @var array<string>
   */
  protected $fillable = [
    'year',
    'semester'
  ];

  /**
   * casts for the model
   * 
   * @var array<string, string>
   */
  protected $casts = [
    'year' => 'integer',
    'semester' => SemesterType::class
  ];

  /**
   * get formatted period name
   * 
   * @return \Illuminate\Database\Eloquent\Casts\Attribute<string>
   */
  protected function name(): Attribute
  {
    return Attribute::make(
      get: fn() => $this->semester->label() . " - " . $this->year
    );
  }

  /**
   * get evaluations in this period
   * 
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function evaluations()
  {
    return $this->hasMany(EmployeeEvaluation::class);
  }

  /**
   * get trainings in this period
   * 
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function trainings()
  {
    return $this->hasMany(EmployeeTraining::class);
  }

  /**
   * get feedback in this period
   * 
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function feedback()
  {
    return $this->hasMany(Feedback::class);
  }
}
