<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HappeningNowEventNotification extends Notification
{
    use Queueable;
    public $event_id;
    public $event_name;
    public $content;
    public $route_name;
    /**
     * Create a new notification instance.
     */
    public function __construct($event_id, $event_name, $content, $route_name)
    {
        $this->event_id = $event_id;
        $this->event_name = $event_name;
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
            'event_id' => $this->event_id,
            'event_name' => $this->event_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "Happening Now!, " .$this->event_name. ', click to see more details.'
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
            'event_id' => $this->event_id,
            'event_name' => $this->event_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "Happening Now!, " .$this->event_name. ', click to see more details.'
        ];
    }
}
