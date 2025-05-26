<?php

use App\Models\User;
use App\Enums\RoleType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

if (app()->environment('local')) {
  Route::middleware('auth')
    ->as('development.')
    ->prefix('development')
    ->group(function () {
      Route::get('migrate', function () {
        $user = Auth::user();
        Artisan::call('migrate:fresh', ['--seed' => true]);

        Auth::loginUsingId($user->id);
        session()->forget('period_id');

        return back()->with('success', 'Database migrated and seeded successfully.');
      })->name('migrate');

      Route::get('reset', function () {
        $user = Auth::user();

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);

        Auth::loginUsingId($user->id);
        session()->forget('period_id');


        return back()->with('success', 'Database migrated successfully.');
      })->name('reset');

      Route::get('impersonate', function () {
        $sysadmin = User::where('role', RoleType::SYSADMIN)->first();
        $manager = User::where('role', RoleType::MANAGER)->first();
        $supervisor = User::where('role', RoleType::SUPERVISOR)->first();
        $pd = User::where('role', RoleType::PD)->first();

        $role = request()->get('role');

        match ($role) {
          RoleType::SYSADMIN->value => Auth::login($sysadmin),
          RoleType::MANAGER->value => Auth::login($manager),
          RoleType::SUPERVISOR->value => Auth::login($supervisor),
          RoleType::PD->value => Auth::login($pd),
        };

        return back()->with('success', 'Impersonated as ' . $role);
      })->name('impersonate');
    });
}
