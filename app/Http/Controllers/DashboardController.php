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
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  /**
   * Show the application dashboard.
   */
  public function index()
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
        'value' => EmployeeEvaluation::with('period')->count(),
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

  /**
   * Show the help center page.
   */
  public function help()
  {
    $faqs = array_to_object(
      [
        [
          'question' => 'How do I update my profile?',
          'answer' => 'You can update your profile by clicking on the Profile menu on the sidebar or by clicking on your avatar on the top right corner and selecting Profile.',
        ],
        [
          'question' => 'How do I change my password?',
          'answer' => 'You can change your password in the same profile update page by clicking on the Update Password button.',
        ],
      ]
    );

    return view('other.help', [
      'faqs' => $faqs,
    ]);
  }

  /**
   * Show the settings page.
   */
  public function settings()
  {
    return view('other.settings');
  }
}
