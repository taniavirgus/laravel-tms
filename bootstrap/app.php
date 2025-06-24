<?php

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\PeriodMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->web([PeriodMiddleware::class]);
    $middleware->alias([
      'role' => RoleMiddleware::class
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })
  ->withSchedule(function ($schedule) {
    $schedule->command('send:training-reminder')->dailyAt('10:00');
  })
  ->create();
