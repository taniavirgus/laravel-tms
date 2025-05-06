<?php

namespace App\Models;

use App\Enums\LevelType;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'description',
    'level',
    'requirements',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'requirements' => 'array',
      'level' => LevelType::class,
    ];
  }
}
