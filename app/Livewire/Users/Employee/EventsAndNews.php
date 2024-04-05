<?php

namespace App\Livewire\Users\Employee;

use App\Models\Announcements;
use App\Models\Events;
use Livewire\Component;

class EventsAndNews extends Component
{
    public $addModal;
    public $addModalContent = "events";
    public $events_happening_now;
    public $announcement_happening_now;
    public $incomming_events;
    public $incomming_announcements;
    public $past_events;
    public $past_announcements;
    public $parameter_id;
    public $content;
    public function mount($id, $content)
    {
        if($id != null){
            $this->parameter_id = $id;
        }

        if($content != null){
            $this->content = $content;
        }
    }

    public function render()
    {
        $date = date('Y-m-d', time());
        $this->events_happening_now = Events::where('when', $date)->get();
        $this->announcement_happening_now = Announcements::where('when', $date)->get();

        $this->incomming_events = Events::where('when', '!=', $date)
                                            ->where('status', 'pending')->get();
        $this->incomming_announcements = Announcements::where('when', '!=', $date)
                                        ->where('status', 'pending')->get();
        
        $this->past_events = Events::where('status', 'done')->get();                                
        $this->past_announcements = Announcements::where('status', 'done')->get();                                

        

        return view('livewire.users.employee.events-and-news');

    }
}
