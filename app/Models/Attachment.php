<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'url',
    'size',
    'filename',
    'mime_type',
    'attachable_id',
    'attachable_type',
  ];

  /**
   * Get the parent attachable model. 
   * 
   * @return \Illuminate\Database\Eloquent\Relations\MorphTo
   */
  public function attachable(): MorphTo
  {
    return $this->morphTo();
  }
}
