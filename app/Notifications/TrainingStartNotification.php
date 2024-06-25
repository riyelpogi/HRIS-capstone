<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrainingStartNotification extends Notification
{
    use Queueable;
    public $employee_id;
    public $training_id;
    public $training_name;
    public $content;
    public $route_name;
    /**
     * Create a new notification instance.
     */
    public function __construct($employee_id, $training_id, $training_name, $content, $route_name)
    {
        $this->employee_id = $employee_id;
        $this->training_id = $training_id;
        $this->training_name = $training_name;
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
        if($this->employee_id == 'EID1'){
            return [
            'employee_id' => $this->employee_id,
            'training_id' => $this->training_id,
            'training_name' => $this->training_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "The " . $this->training_name . " has been started today, goodluck!"
        ];
        }else{
            return [
                'employee_id' => $this->employee_id,
                'training_id' => $this->training_id,
                'training_name' => $this->training_name,
                'content' => $this->content,
                'route_name' => $this->route_name,
                'message' => "Your " . $this->training_name . " has been started today, goodluck!"
            ];
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        if($this->employee_id == 'EID1'){
            return [
            'employee_id' => $this->employee_id,
            'training_id' => $this->training_id,
            'training_name' => $this->training_name,
            'content' => $this->content,
            'route_name' => $this->route_name,
            'message' => "The " . $this->training_name . " has been started today, goodluck!"
        ];
        }else{
            return [
                'employee_id' => $this->employee_id,
                'training_id' => $this->training_id,
                'training_name' => $this->training_name,
                'content' => $this->content,
                'route_name' => $this->route_name,
                'message' => "Your " . $this->training_name . " has been started today, goodluck!"
            ];
        }
    }
}
