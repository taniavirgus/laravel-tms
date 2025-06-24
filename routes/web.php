<?php

use App\Enums\RoleType;
use App\Helpers\MiddlewareRule;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\TalentTrainingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
  ->controller(DashboardController::class)
  ->group(function () {
    Route::get('/', 'index')->name('dashboard');
  });

Route::middleware('auth')
  ->prefix('config')
  ->as('config.')
  ->controller(DashboardController::class)
  ->group(function () {
    Route::get('/help', 'help')->name('help');
    Route::get('/settings', 'settings')->name('settings');
  });

Route::middleware('auth')
  ->controller(ProfileController::class)
  ->prefix('profile')
  ->as('profile.')
  ->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
  });

Route::middleware('auth', MiddlewareRule::role(
  'role',
  RoleType::SYSADMIN,
  RoleType::PD,
  RoleType::MANAGER,
  RoleType::SUPERVISOR
))
  ->group(function () {
    Route::controller(EmployeeController::class)->group(function () {
      Route::get('employees/export', 'export')->name('employees.export');
    });
    Route::resource('employees', EmployeeController::class);

    Route::controller(PeriodController::class)->group(function () {
      Route::post('periods/switch', 'switch')->name('periods.switch');
    });
  });

Route::middleware('auth', MiddlewareRule::role(
  'role',
  RoleType::SYSADMIN
))
  ->group(function () {
    Route::resource('periods', PeriodController::class);
    Route::resource('users', UserController::class)->except('show');
    Route::resource('positions', PositionController::class)->except('show');
    Route::resource('departments', DepartmentController::class)->except('show');
  });

Route::get('talents/{talent}/material', [TalentTrainingController::class, 'material'])->name('talents.material');
Route::get('trainings/{training}/material', [TrainingController::class, 'material'])->name('trainings.material');

Route::middleware('auth', MiddlewareRule::role(
  'role',
  RoleType::PD,
  RoleType::MANAGER,
  RoleType::SUPERVISOR
))
  ->group(function () {
    Route::resource('topics', TopicController::class)->except('show');

    Route::controller(SegmentController::class)->group(function () {
      Route::get('segments/export/{segment}', 'export')->name('segments.export');
    });
    Route::resource('segments', SegmentController::class)->only(['index', 'show']);

    Route::controller(EmployeeController::class)->group(function () {
      Route::patch('employees/{employee}/score', 'score')->name('employees.score');
    });

    Route::controller(EvaluationController::class)->group(function () {
      Route::get('evaluations/summary', 'summary')->name('evaluations.summary');
      Route::get('evaluations/export', 'export')->name('evaluations.export');
      Route::post('evaluations/{evaluation}/assign', 'assign')->name('evaluations.assign');
      Route::patch('evaluations/{evaluation}/score', 'score')->name('evaluations.score');
      Route::patch('evaluations/{evaluation}/approval', 'approval')->name('evaluations.approval');
      Route::delete('evaluations/{evaluation}/unassign/{employee}', 'unassign')->name('evaluations.unassign');
    });

    Route::resource('evaluations', EvaluationController::class);
    Route::resource('employees.feedback', FeedbackController::class)->shallow()->only('create', 'store', 'destroy');

    Route::controller(TrainingController::class)->group(function () {
      Route::get('trainings/export', 'export')->name('trainings.export');
      Route::patch('trainings/{training}/score', 'score')->name('trainings.score');
      Route::post('trainings/{training}/assign', 'assign')->name('trainings.assign');
      Route::post('trainings/{training}/notify', 'notify')->name('trainings.notify');
      Route::post('trainings/{training}/upload', 'upload')->name('trainings.upload');
      Route::delete('trainings/{training}/remove/{attachment}', 'remove')->name('trainings.remove');
      Route::delete('trainings/{training}/unassign/{employee}', 'unassign')->name('trainings.unassign');
    });

    Route::resource('trainings', TrainingController::class);

    Route::controller(TalentTrainingController::class)->group(function () {
      Route::get('talents/export', 'export')->name('talents.export');
      Route::patch('talents/{talent}/score/{employee}', 'score')->name('talents.score');
      Route::post('talents/{talent}/assign', 'assign')->name('talents.assign');
      Route::post('talents/{talent}/notify', 'notify')->name('talents.notify');
      Route::post('talents/{talent}/upload', 'upload')->name('talents.upload');
      Route::delete('talents/{talent}/remove/{attachment}', 'remove')->name('talents.remove');
      Route::delete('talents/{talent}/unassign/{employee}', 'unassign')->name('talents.unassign');
    });

    Route::resource('talents', TalentTrainingController::class);
  });


require __DIR__ . '/auth.php';
require __DIR__ . '/development.php';
