<?php

namespace App\Notifications;

use App\Models\Employee;
use App\Models\TalentTraining;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TalentTrainingNotification extends Notification implements ShouldQueue
{
  use Queueable;

  /**
   * Create a new notification instance.
   */
  public function __construct(
    public TalentTraining $talent,
    public Employee $employee
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
    return (new MailMessage)->subject('Talent Training Notification')
      ->greeting('Hello ' . $this->employee->name . ',')
      ->line('You have been assigned to a new talent training: ' . $this->talent->name)
      ->line('Description: ' . $this->talent->description)
      ->line('Start Date: ' . $this->talent->start_date->format('d-m-Y'))
      ->line('End Date: ' . $this->talent->end_date->format('d-m-Y'))
      ->line('Duration: ' . $this->talent->duration . ' hours')
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
      'talent' => $this->talent,
      'employee' => $this->employee,
    ];
  }
}
