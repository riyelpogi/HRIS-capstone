<?php

namespace App\Livewire\Users\Applicant;

use Livewire\Component;

class Notifications extends Component
{
    public $notifications;
    public $unread;

    public function readNotifications()
    {
        sleep(2);
        foreach(auth()->user()->unreadNotifications as $notification){
            $notification->markAsRead();
        }
    }

    public function render()
    {
        $this->notifications = auth()->user()->notifications->take(7);
        $this->unread = auth()->user()->unreadNotifications;
        return view('livewire.users.applicant.notifications');
    }
}
