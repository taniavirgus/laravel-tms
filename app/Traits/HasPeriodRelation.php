<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPeriodRelation
{
  /**
   * create a belongstomany relationship with period scoping
   * 
   * @param string $related
   * @param string|null $table
   * @param string|null $foreignPivotKey
   * @param string|null $relatedPivotKey
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function belongsToManyWithPeriod($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null): BelongsToMany
  {
    $period = session('period_id');

    return $this->belongsToMany($related, $table, $foreignPivotKey, $relatedPivotKey)
      ->withPivot('period_id')
      ->withTimestamps()
      ->wherePivot('period_id', $period);
  }
}
