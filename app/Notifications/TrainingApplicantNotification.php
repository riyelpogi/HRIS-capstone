<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrainingApplicantNotification extends Notification
{
    use Queueable;
    public $employee_id;
    public $training_id;
    public $route_name;
    public $content;
    public $training_name;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee_id, $training_id, $training_name, $content, $route_name)
    {
        $this->employee_id = $employee_id;
        $this->training_id = $training_id;
        $this->training_name = $training_name;
        $this->content = $content;
        $this->route_name = $route_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'employee_id' => $this->employee_id,
            'training_id' => $this->training_id,
            'training_name' => $this->training_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "You have a new applicant on " . $this->training_name . ", click to see more details.",
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'employee_id' => $this->employee_id,
            'training_id' => $this->training_id,
            'training_name' => $this->training_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "You have a new applicant on " . $this->training_name . ", click to see more details.",
        ];
    }
}
