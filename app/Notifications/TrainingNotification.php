<?php

namespace App\Notifications;

use App\Models\Employee;
use App\Models\Training;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrainingNotification extends Notification implements ShouldQueue
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
    return (new MailMessage)->subject('Training Notification')
      ->greeting('Hello ' . $this->employee->name . ',')
      ->line('You have been assigned to a new training: ' . $this->training->name)
      ->line('Description: ' . $this->training->description)
      ->line('Start Date: ' . $this->training->start_date->format('d-m-Y'))
      ->line('End Date: ' . $this->training->end_date->format('d-m-Y'))
      ->line('Duration: ' . $this->training->duration . ' hours')
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
      'training' => $this->training,
      'employee' => $this->employee,
    ];
  }
}
