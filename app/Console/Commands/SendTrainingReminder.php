<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Training;
use Illuminate\Console\Command;
use App\Enums\CompletionStatus;
use App\Notifications\TrainingReminderNotification;

class SendTrainingReminder extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'send:training-reminder';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Send training reminders to employees if the training is upcoming';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $days = [1, 3, 7];
    $days = collect($days)->map(fn($day) => Carbon::today()->addDays($day));

    $trainings = Training::query()
      ->withStatus(CompletionStatus::UPCOMING)
      ->with('employees')
      ->whereIn('start_date', $days)
      ->get();

    $trainings->each(function ($training) {
      $training->employees->each(function ($employee) use ($training) {
        $employee->notify(new TrainingReminderNotification(
          $training,
          $employee,
        ));
      });
    });
  }
}
