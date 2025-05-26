<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

/**
 * handles period related operations
 */
class PeriodController extends Controller
{
  /**
   * switch current period
   * 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function switch(Request $request)
  {
    $period = Period::findOrFail($request->period_id);
    session(['period_id' => $period->id]);
    return back()->with('success', "Switched to {$period->name} period");
  }
}
