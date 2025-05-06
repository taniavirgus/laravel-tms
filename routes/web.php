<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:sysadmin')
  ->prefix('sysadmin')
  ->as('sysadmin.')
  ->group(function () {
    Route::resource('users', UserController::class)->except('show');
    Route::resource('positions', PositionController::class)->except('show');
    Route::resource('departments', DepartmentController::class)->except('show');
    Route::resource('employees', EmployeeController::class)->except('show');
  });

require __DIR__ . '/auth.php';
