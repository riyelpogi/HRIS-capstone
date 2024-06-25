<?php

namespace App\Notifications;

use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluationForEmployee extends Notification
{
    use Queueable;
    public $employee_id;
    public $evaluation_id;
    public $month;
    public $content;
    public $route_name;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee_id, $month, $content, $route_name)
    {
        $this->employee_id = $employee_id;
        $this->evaluation_id = 0;
        $this->month = $month;
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
        $month = DateTime::createFromFormat('!m', $this->month);

        return [
            'employee_id' => $this->employee_id,
            'evaluation_id' => $this->evaluation_id,
            'month' => $this->month,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => 'You have a new evaluation for the month of ' . $month->format('F') . ', click to see more details.'
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $month = DateTime::createFromFormat('!m', $this->month);

        return [
            'employee_id' => $this->employee_id,
            'evaluation_id' => $this->evaluation_id,
            'month' => $this->month,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => 'You have a new evaluation for the month of ' . $month->format('F') . ', click to see more details.'
        ];
    }
}
