<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HappeningNowAnnouncementNotification extends Notification
{
    use Queueable;
    public $announcement_id;
    public $announcement_name;
    public $content;
    public $route_name;
    /**
     * Create a new notification instance.
     */
    public function __construct($announcement_id, $announcement_name, $content, $route_name)
    {
        $this->announcement_id = $announcement_id;
        $this->announcement_name = $announcement_name;
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
            'announcement_id' => $this->announcement_id,
            'announcement_name' => $this->announcement_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "Happening Now!, " .$this->announcement_name. ', click to see more details.'
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
            'announcement_id' => $this->announcement_id,
            'announcement_name' => $this->announcement_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "Happening Now!, " .$this->announcement_name. ', click to see more details.'
        ];
    }
}
