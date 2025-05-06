<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
  /**
   * Create a new controller instance.
   * 
   * @return void
   */
  public function __construct()
  {
    $this->authorizeResource(Department::class);
  }

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request): View
  {
    $search = $request->input('search');

    $departments = Department::query()
      ->when($search, function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')
          ->orWhere('description', 'like', '%' . $search . '%');
      })
      ->paginate(10);

    return view('dashboard.departments.index', [
      'departments' => $departments
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(): View
  {
    return view('dashboard.departments.create', [
      'department' => new Department()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreDepartmentRequest $request): RedirectResponse
  {
    $validated = $request->validated();
    $department = Department::create($validated);

    return redirect()
      ->route('sysadmin.departments.index')
      ->with('success', 'Department created successfully.');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Department $department): View
  {
    return view('dashboard.departments.edit', [
      'department' => $department
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
  {
    $validated = $request->validated();
    $department->update($validated);

    return redirect()
      ->route('sysadmin.departments.index', $department)
      ->with('success', 'Department updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Department $department): RedirectResponse
  {
    $department->delete();

    return redirect()
      ->route('sysadmin.departments.index')
      ->with('success', 'Department deleted successfully.');
  }
}
