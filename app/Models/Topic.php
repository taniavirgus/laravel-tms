<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'description',
  ];

  /**
   * Relationship with between model and other model.
   * 
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function evaluations()
  {
    return $this->hasMany(Evaluation::class);
  }
}
