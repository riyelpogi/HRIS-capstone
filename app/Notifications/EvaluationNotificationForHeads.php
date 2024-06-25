<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationNotificationForHeads extends Notification
{
    use Queueable;
    public $evaluation_id;
    public $content;
    public $route_name;
    public $month;
    /**
     * Create a new notification instance.
     */
    public function __construct($evaluation_id, $month, $content, $route_name)
    {
        $this->evaluation_id = $evaluation_id;
        $this->content = $content;
        $this->route_name = $route_name;
        $this->month = $month;
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
            'evaluation_id' => $this->evaluation_id,
            'month' => $this->month,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => 'There is a new evaluation for the month of ' . $this->month . ', click to see more details.',
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
            'evaluation_id' => $this->evaluation_id,
            'month' => $this->month,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => 'There is a new evaluation for the month of ' . $this->month . ', click to see more details.',
        ];
    }
}
