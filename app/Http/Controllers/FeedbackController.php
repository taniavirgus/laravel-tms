<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Employee;

class FeedbackController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->authorizeResource(Feedback::class);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Employee $employee)
  {
    return view('dashboard.feedbacks.create', [
      'employee' => $employee,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreFeedbackRequest $request, Employee $employee)
  {
    $validated = $request->validated();

    Feedback::updateOrInsert([
      'employee_id' => $employee->id,
      'period_id' => session('period_id')
    ], $validated);

    return redirect()
      ->route('employees.show', $employee->id)
      ->with('success', 'Feedback created successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Feedback $feedback)
  {
    $feedback->delete();

    return redirect()
      ->route('employees.show', $feedback->employee_id)
      ->with('success', 'Feedback reset successfully.');
  }
}
