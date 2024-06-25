<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HiredNotification extends Notification
{
    use Queueable;
    public $name;
    public $position;
    public $department;
    public $date;
    /**
     * Create a new notification instance.
     */
    public function __construct($name, $position, $department, $date)
    {   
        $this->name = $name;
        $this->position = $position;
        $this->department = $department;
        $this->date = $date;
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
            'name' => $this->name,
            'position'=> $this->position,
            'department'=> $this->department,
            'date'=> $this->date,
            'message' => "Congatulations!, ".$this->name. " you have been hired for the position of " . $this->position . "(" . $this->department . " - ". $this->date.")"
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
            'name' => $this->name,
            'position'=> $this->position,
            'department'=> $this->department,
            'date'=> $this->date,
            'message' => "Congatulations!," .$this->name. " you have been hired for the position of " . $this->position . "(" . $this->department . " - ". $this->date.")"
        ];
    }
}
