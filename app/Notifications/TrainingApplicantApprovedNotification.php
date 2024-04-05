<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrainingApplicantApprovedNotification extends Notification
{
    use Queueable;
    public $employee_id;
    public $training_id;
    public $training_name;
    public $content;
    public $route_name;
    public $from_date;
    public $to_date;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee_id, $training_id, $training_name, $content, $route_name, $from_date, $to_date)
    {
        $this->employee_id = $employee_id;
        $this->training_id = $training_id;
        $this->training_name = $training_name;
        $this->content = $content;
        $this->route_name = $route_name;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
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
            'training_id' => $this->training_id,
            'training_name' => $this->training_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "Your application in " . $this->training_name . " has been approved by the admin, this training will start on " . $this->from_date . " until " . $this->to_date ." be ready, click to se more details" ,  
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
            'training_id' => $this->training_id,
            'training_name' => $this->training_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "Your application in " . $this->training_name . " has been approved by the admin, this training will start on " . $this->from_date . " until ". $this->to_date ." be ready, click to se more details" ,  

        ];
    }
}
