<?php

namespace App\Livewire\Users\Hrofficer;

use Livewire\Component;

class AdminNotification extends Component
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
        $this->notifications = auth()->user()->notifications->take(10);
        $this->unread = auth()->user()->unreadNotifications;
        return view('livewire.users.hrofficer.admin-notification');
    }
}
