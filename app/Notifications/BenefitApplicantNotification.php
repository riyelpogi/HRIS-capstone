<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BenefitApplicantNotification extends Notification
{
    use Queueable;
    public $employee_id;
    public $benefit_id;
    public $benefit_name;
    public $route_name;
    public $content;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee_id, $benefit_id, $benefit_name, $route_name, $content)
    {
        $this->employee_id = $employee_id;
        $this->benefit_id = $benefit_id;
        $this->benefit_name = $benefit_name;
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
            'benefit_id' => $this->benefit_id,
            'benefit_name' => $this->benefit_name,
            'route_name' => $this->route_name,
            'content' => $this->content,
            'message' => 'You have new applicant on benefit ' . $this->benefit_name . '.',
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
            'benefit_id' => $this->benefit_id,
            'benefit_name' => $this->benefit_name,
            'route_name' => $this->route_name,
            'content' => $this->content,
            'message' => 'You have new applicant on benefit ' . $this->benefit_name . '.',
        ];
    }
}
