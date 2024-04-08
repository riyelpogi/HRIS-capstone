<?php

namespace App\Livewire\Users\Employee;

use Livewire\Component;

class EmployeeNotification extends Component
{
    public $notifications;
    public $unread;
    public function readNotifications()
    {
        sleep(3);
        foreach (auth()->user()->unreadNotifications as $key => $notification) {
            $notification->markAsRead();
        }
    }    
    
    public function render()
    {
        $this->notifications = auth()->user()->notifications->take(5);
        $this->unread = auth()->user()->unreadNotifications;
        return view('livewire.users.employee.employee-notification');
    }
}
