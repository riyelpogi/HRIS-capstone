<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApplicantsNotification extends Notification
{
    use Queueable;
    public $job_title;
    public $job_id;
    /**
     * Create a new notification instance.
     */
    public function __construct( $job_title, $job_id)
    {
        $this->job_title = $job_title;
        $this->job_id = $job_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'job_title' => $this->job_title,
            'job_id' => $this->job_id,
            'route_name' => 'admin.application.tracker',
            'message' => "You have new applicant on " . $this->job_title . ' (' . $this->job_id . ').'
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
            'job_title' => $this->job_title,
            'job_id' => $this->job_id,
            'route_name' => 'admin.application.tracker',
            'message' => "You have new applicant on " . $this->job_title . ' (' . $this->job_id . ')'
        ];
    }
}
