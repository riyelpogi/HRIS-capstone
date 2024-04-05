<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApprovedRequest extends Notification
{
    use Queueable;
    public $employee_id;
    public $request_id;
    public $content;
    public $content_of_content;
    public $route_name;
    public $message;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee_id, $request_id, $content, $content_of_content, $message, $route_name)
    {
        $this->employee_id = $employee_id;
        $this->request_id = $request_id;
        $this->content = $content;
        $this->content_of_content = $content_of_content;
        $this->message = $message;
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
            'request_id' => $this->request_id,
            'content' => $this->content,
            'content_of_content' => $this->content_of_content,
            'route_name' => $this->route_name,
            'message' => $this->message  
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
            'request_id' => $this->request_id,
            'content' => $this->content,
            'content_of_content' => $this->content_of_content,
            'route_name' => $this->route_name,
            'message' => $this->message  
        ];
    }
}
