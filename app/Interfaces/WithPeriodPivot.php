<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface WithPeriodPivot
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
  public function belongsToManyWithPeriod($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null): BelongsToMany;
}
