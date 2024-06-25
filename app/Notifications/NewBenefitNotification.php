<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBenefitNotification extends Notification
{
    use Queueable;
    public $benefit_id;
    public $route_name;
    public $content;
    /**
     * Create a new notification instance.
     */
    public function __construct($benefit_id, $route_name, $content)
    {
        $this->benefit_id = $benefit_id;
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
            'benefit_id' => $this->benefit_id,
            'route_name' => $this->route_name,
            'content' => $this->content,
            'message' => "Theres a new benefit for employee, click to see more details."
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
            'benefit_id' => $this->benefit_id,
            'route_name' => $this->route_name,
            'content' => $this->content,
            'message' => "Theres a new benefit for employee, click to see more details."
        ];
    }
}
