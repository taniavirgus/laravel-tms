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
use App\Http\Controllers\TalentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', MiddlewareRule::role(
  'role',
  RoleType::SYSADMIN,
  RoleType::PD,
  RoleType::MANAGER,
  RoleType::SUPERVISOR
))
  ->group(function () {
    Route::resource('employees', EmployeeController::class);
  });

Route::middleware('auth', MiddlewareRule::role(
  'role',
  RoleType::SYSADMIN
))
  ->group(function () {
    Route::resource('users', UserController::class)->except('show');
    Route::resource('positions', PositionController::class)->except('show');
    Route::resource('departments', DepartmentController::class)->except('show');
  });

Route::middleware('auth', MiddlewareRule::role(
  'role',
  RoleType::PD,
  RoleType::MANAGER,
  RoleType::SUPERVISOR
))
  ->group(function () {
    Route::resource('topics', TopicController::class)->except('show');
    Route::resource('talents', TalentController::class)->only(['index', 'show']);

    Route::controller(EmployeeController::class)->group(function () {
      Route::patch('employees/{employee}/score', 'score')->name('employees.score');
    });

    Route::controller(EvaluationController::class)->group(function () {
      Route::get('evaluations/summary', 'summary')->name('evaluations.summary');
      Route::post('evaluations/{evaluation}/assign', 'assign')->name('evaluations.assign');
      Route::patch('evaluations/{evaluation}/score', 'score')->name('evaluations.score');
      Route::patch('evaluations/{evaluation}/approval', 'approval')->name('evaluations.approval');
      Route::delete('evaluations/{evaluation}/unassign/{employee}', 'unassign')->name('evaluations.unassign');
    });

    Route::resource('evaluations', EvaluationController::class);
    Route::resource('employees.feedback', FeedbackController::class)->shallow()->only('create', 'store', 'destroy');

    Route::controller(TrainingController::class)->group(function () {
      Route::patch('trainings/{training}/score', 'score')->name('trainings.score');
      Route::post('trainings/{training}/assign', 'assign')->name('trainings.assign');
      Route::post('trainings/{training}/notify', 'notify')->name('trainings.notify');
      Route::delete('trainings/{training}/unassign/{employee}', 'unassign')->name('trainings.unassign');
    });

    Route::resource('trainings', TrainingController::class);
  });

require __DIR__ . '/auth.php';
require __DIR__ . '/development.php';
