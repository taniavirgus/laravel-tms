<?php

namespace App\Notifications;

use App\Models\Employee;
use App\Models\Training;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class TrainingReminderNotification extends Notification implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   */
  public function __construct(
    public Training $training,
    public Employee $employee,
  ) {
    //
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['mail'];
  }

  /**
   * Get the mail representation of the notification.
   */
  public function toMail(object $notifiable): MailMessage
  {
    $today = Carbon::today();
    $day = $this->training->start_date->diffInDays($today);

    return (new MailMessage)
      ->subject('Training Reminder')
      ->greeting('Hello ' . $this->employee->name . ',')
      ->line('This is a reminder for your upcoming training:')
      ->line('You have "' . $this->training->name . '" starting in ' . $day . ' day(s).')
      ->line('Description: ' . $this->training->description)
      ->line('Start Date: ' . $this->training->start_date->format('d-m-Y'))
      ->line('End Date: ' . $this->training->end_date->format('d-m-Y'))
      ->line('Duration: ' . $this->training->duration . ' hours')
      ->line('Please prepare accordingly.')
      ->line('Thank you!');
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      //
    ];
  }
}
