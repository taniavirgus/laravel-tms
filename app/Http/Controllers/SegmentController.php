<?php

namespace App\Http\Controllers;

use App\Enums\SegmentType;
use App\Exports\SegmentExport;
use App\Models\Employee;
use App\Models\TalentTraining;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use App\Models\Department;

class SegmentController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(): View
  {
    $employees = Employee::with('trainings', 'evaluations', 'feedback')
      ->where('status','active')
      ->get()
      ->map(function ($employee) {
        $employee->matrix = $employee->matrix();
        return $employee;
      });

    $segments = collect(SegmentType::cases())->map(function ($type) use ($employees) {
      return (object) [
        'type' => $type,
        'count' => $employees->filter(fn($employee) => $employee->matrix->segment === $type)->count(),
      ];
    })->values();

    return view('dashboard.segments.index', [
      'segments' => $segments,
      'totals' => $employees->count(),
      
    ]);
  }

  /**
   * Display the specified resource.
   */
public function show(string $segment): View
{
    $segment = SegmentType::from($segment);

    $employees = Employee::with('trainings', 'evaluations', 'feedback')
        ->get()
        ->map(function ($employee) {
            $employee->matrix = $employee->matrix();
            return $employee;
        });

    $employees = $employees
        ->load('department', 'position')
        ->filter(fn($employee) => $employee->matrix->segment === $segment);

    // 🔍 Tambahan: filter by department
    if (request()->filled('department_id')) {
        $employees = $employees->filter(fn($employee) =>
            $employee->department_id == request()->get('department_id')
        );
    }

    // 🔍 Tambahan: filter by search
    if (request()->filled('search')) {
        $search = strtolower(request()->get('search'));
        $employees = $employees->filter(fn($employee) =>
            str_contains(strtolower($employee->name), $search)
        );
    }

    $employees = $employees->sortByDesc('matrix.average_score');

    $employees = new LengthAwarePaginator(
        $employees->forPage(request()->get('page', 1), request()->get('per_page', 5)),
        $employees->count(),
        request()->get('per_page', 5),
        request()->get('page', 1),
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $talents = TalentTraining::where('segment', $segment)->get();

    return view('dashboard.segments.show', [
        'talents' => $talents,
        'employees' => $employees,
        'segment' => $segment,
        'departments' => Department::orderBy('name')->get(),
    ]);
}


  /**
   * Export the segment into csv file.
   */
  public function export(Request $request, string $segment)
  {
    $segment = SegmentType::from($segment);
    return Excel::download(new SegmentExport($segment), $segment->value . '.csv', ExcelFormat::CSV);
  }
}
