<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketsNotification extends Notification
{
    use Queueable;
    public $employee_id;
    public $route_name;
    public $content;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee_id, $route_name, $content)
    {
        $this->employee_id = $employee_id;
        $this->route_name = $route_name;
        $this->content = $content;
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
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => 'You have a new ticket, please see employee in&out for more details'
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
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => 'You have a new ticket, please see employee in&out for more details'
        ];
    }
}
