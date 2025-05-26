<?php

namespace App\Http\Middleware;

use App\Enums\SemesterType;
use App\Models\Period;
use Closure;
use Illuminate\Http\Request;

/**
 * middleware to set current period in session
 * 
 * sets the latest period as current if none is set in session
 */
class PeriodMiddleware
{
  /**
   * handle incoming request
   * 
   * @param \Illuminate\Http\Request $request
   * @param \Closure $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    $check = session()->has('period_id');
    if ($check) return $next($request);

    $period = Period::firstOrCreate([
      'year' => now()->year,
      'semester' => now()->month > 6 ? SemesterType::ODD : SemesterType::EVEN,
    ]);

    session(['period_id' => $period->id]);
    return $next($request);
  }
}
