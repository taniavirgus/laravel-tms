<?php

use App\Enums\RoleType;
use App\Helpers\MiddlewareRule;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', MiddlewareRule::role('role', RoleType::SYSADMIN, RoleType::PD))
  ->group(function () {
    Route::resource('employees', EmployeeController::class)->except('show');
  });

Route::middleware('auth', MiddlewareRule::role('role', RoleType::SYSADMIN))
  ->group(function () {
    Route::resource('users', UserController::class)->except('show');
    Route::resource('positions', PositionController::class)->except('show');
    Route::resource('departments', DepartmentController::class)->except('show');
  });

Route::middleware('auth', MiddlewareRule::role('role', RoleType::PD, RoleType::MANAGER, RoleType::SUPERVISOR))
  ->group(function () {
    Route::resource('topics', TopicController::class)->except('show');
    Route::resource('evaluations', EvaluationController::class);

    Route::controller(EvaluationController::class)->group(function () {
      Route::post('evaluations/{evaluation}/assign', 'assign')->name('evaluations.assign');
      Route::patch('evaluations/{evaluation}/approval', 'approval')->name('evaluations.approval');
      Route::delete('evaluations/{evaluation}/unassign/{employee}', 'unassign')->name('evaluations.unassign');
    });
  });

require __DIR__ . '/auth.php';
