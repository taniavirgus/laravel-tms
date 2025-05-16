<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalType;
use App\Enums\RoleType;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeEvaluation;
use App\Models\Evaluation;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  /**
   * Show the application dashboard.
   */
  public function __invoke(Request $request)
  {
    $widgets = array_to_object([
      [
        'icon' => 'users',
        'label' => 'Total Users',
        'description' => 'Number of users in system',
        'value' => User::count(),
        'show' => Auth::user()->role == RoleType::SYSADMIN,
      ],
      [
        'icon' => 'building',
        'label' => 'Total Departments',
        'description' => 'Number of departments in system',
        'value' => Department::count(),
        'show' => Auth::user()->role == RoleType::SYSADMIN,
      ],
      [
        'icon' => 'briefcase',
        'label' => 'Total Employees',
        'description' => 'Number of employees in system',
        'value' => Employee::count(),
        'show' => Auth::user()->role == RoleType::SYSADMIN,
      ],
      [
        'icon' => 'tags',
        'label' => 'Total Topics',
        'description' => 'Number of topics in system',
        'value' => Topic::count(),
        'show' => Auth::user()->role == RoleType::SYSADMIN,
      ],
      [
        'icon' => 'clipboard',
        'label' => 'Total Evaluations',
        'description' => 'Number of evaluations in system',
        'value' => Evaluation::count(),
        'show' => in_array(Auth::user()->role, [
          RoleType::PD,
          RoleType::MANAGER,
          RoleType::SUPERVISOR,
        ]),
      ],
      [
        'icon' => 'clipboard-check',
        'label' => 'Total Approved Evaluations',
        'description' => 'Number of approved evaluations',
        'value' => Evaluation::where('status', ApprovalType::APPROVED)->count(),
        'show' => in_array(Auth::user()->role, [
          RoleType::PD,
          RoleType::MANAGER,
          RoleType::SUPERVISOR,
        ]),
      ],
      [
        'icon' => 'clipboard-list',
        'label' => 'Total Pending Evaluations',
        'description' => 'Number of pending evaluations',
        'value' => Evaluation::where('status', ApprovalType::DRAFT)->count(),
        'show' => in_array(Auth::user()->role, [
          RoleType::PD,
          RoleType::MANAGER,
          RoleType::SUPERVISOR,
        ]),
      ],
      [
        'icon' => 'user-check',
        'label' => 'Employee evaluated',
        'description' => 'Number of employees evaluated',
        'value' => EmployeeEvaluation::count(),
        'show' => in_array(Auth::user()->role, [
          RoleType::PD,
          RoleType::MANAGER,
          RoleType::SUPERVISOR,
        ]),
      ]
    ]);

    return view('dashboard', [
      'widgets' => $widgets,
    ]);
  }
}
