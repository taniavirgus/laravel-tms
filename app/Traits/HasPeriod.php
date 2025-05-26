<?php

namespace App\Traits;

use App\Models\Period;
use Illuminate\Database\Eloquent\Builder;

trait HasPeriod
{
  /**
   * boot the trait
   * 
   * adds global scope to filter by current period from session
   * and sets current period on model creation
   */
  protected static function bootHasPeriod()
  {
    static::addGlobalScope('period', function (Builder $builder) {
      $builder->where('period_id', session('period_id'));
    });

    static::creating(function ($model) {
      $model->period_id = session('period_id');
    });
  }

  /**
   * get related period
   * 
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Period, self>
   */
  public function period()
  {
    return $this->belongsTo(Period::class);
  }

  /**
   * scope to filter by specific period
   * 
   * @param \Illuminate\Database\Eloquent\Builder<self> $query
   * @param int $period_id
   * @return \Illuminate\Database\Eloquent\Builder<self>
   */
  public function scopeForPeriod(Builder $query, $period_id)
  {
    return $query->withoutPeriod()->where('period_id', $period_id);
  }

  /**
   * get query without period scope
   * 
   * @return \Illuminate\Database\Eloquent\Builder<self>
   */
  public function scopeWithoutPeriod(Builder $query)
  {
    return $query->withoutGlobalScope('period');
  }
}
