<?php

namespace App\Http\Controllers;

use App\Enums\SemesterType;
use App\Models\Period;
use App\Http\Requests\StorePeriodRequest;
use App\Http\Requests\UpdatePeriodRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * handles period related operations
 */
class PeriodController extends Controller
{
  /**
   * create a new controller instance
   */
  public function __construct()
  {
    $this->authorizeResource(Period::class);
  }

  /**
   * display a listing of periods
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');

    $periods = Period::query()
      ->withCount(['evaluations', 'trainings', 'feedback'])
      ->when($search, function ($q) use ($search) {
        $q->where('year', 'like', '%' . $search . '%')
          ->orWhere('semester', 'like', '%' . $search . '%');
      })
      ->paginate(5)
      ->withQueryString();

    return view('dashboard.periods.index', [
      'periods' => $periods,
    ]);
  }

  /**
   * show form for creating period
   */
  public function create(): View
  {
    return view('dashboard.periods.create', [
      'semesters' => SemesterType::cases(),
    ]);
  }

  /**
   * store a new period
   */
  public function store(StorePeriodRequest $request): RedirectResponse
  {
    $validated = $request->validated();
    Period::create($validated);

    return redirect()
      ->route('periods.index')
      ->with('success', 'period created successfully.');
  }

  /**
   * show form for editing period
   */
  public function edit(Period $period): View
  {
    return view('dashboard.periods.edit', [
      'period' => $period,
      'semesters' => SemesterType::cases(),
    ]);
  }

  /**
   * update the period
   */
  public function update(UpdatePeriodRequest $request, Period $period): RedirectResponse
  {
    $validated = $request->validated();
    $period->update($validated);

    return redirect()
      ->route('periods.index')
      ->with('success', 'period updated successfully.');
  }

  /**
   * remove the period
   */
  public function destroy(Period $period): RedirectResponse
  {
    $period->delete();

    return redirect()
      ->route('periods.index')
      ->with('success', 'period deleted successfully.');
  }

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
