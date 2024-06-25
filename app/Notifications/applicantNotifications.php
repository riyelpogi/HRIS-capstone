<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class applicantNotifications extends Notification
{
    use Queueable;
    public $user_id;
    public $job;
    public $date;
    public $interview_time;
    public $notification_type;
    /**
     * Create a new notification instance.
     */
    public function __construct($user_id,$job, $date, $interview_time, $notification_type)
    {
        $this->user_id = $user_id;
        $this->job = $job;
        $this->date = $date;
        $this->interview_time = $interview_time;
        $this->notification_type = $notification_type;
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
            'date' => $this->date,
            'interview_time' => $this->interview_time,
            'notification_type' => $this->notification_type 
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
            'date' => $this->date,
            'interview_time' => $this->interview_time,
            'notification_type' => $this->notification_type 
        ];
    }
}
