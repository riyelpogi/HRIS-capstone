<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FailedExamination extends Notification
{
    use Queueable;
    public $user_id;
    public $job;
    public $interview_type;
    public $interview;
    /**
     * Create a new notification instance.
     */
    public function __construct($user_id, $job, $interview)
    {
        $this->user_id = $user_id;
        $this->job = $job;
        $this->interview = $interview;
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
            'user_id' => $this->user_id,
            'job' => $this->job,
            'interview' => $this->interview,
            'notification_type' => 'failed examination',
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
            'user_id' => $this->user_id,
            'job' => $this->job,
            'interview' => $this->interview,
            'notification_type' => 'failed interview',
        ];
    }
}
