<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\Announcements as ModelsAnnouncements;
use App\Models\Events;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use App\Notifications\EventNotification;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Announcements extends Component
{

    public $addModal;
    public $addModalContent = "events";
    public $events_happening_now;
    public $announcement_happening_now;
    public $incomming_events;
    public $incomming_announcements;
    public $past_events;
    public $past_announcements;

    #[Rule('required')]
    public $event_name;
    #[Rule('required')]
    public $description;
    #[Rule('required')]
    public $when;
    #[Rule('required')]
    public $where;
    public $events_saved_success;


    #[Rule('required')]
    public $announcement_name;
    #[Rule('required')]
    public $announcement_description;
    #[Rule('required')]
    public $announcement_when;
    public $announcement_saved_success;

    
    public function saveAnnouncement()
    {
        $this->validate([
            'announcement_name' => 'required',
            'announcement_description' => 'required',
            'announcement_when' => 'required'
        ]);

        if(Gate::allows('admin')){
            $announcement = ModelsAnnouncements::create([
                'announcement_name' => $this->announcement_name,
                'description' => $this->announcement_description,
                'when' => $this->announcement_when
            ]);
            $this->announcement_saved_success = 'Announcement saved successful';
            $route_name = 'employee.eventsandnews';
            $content = 'announcement';
            $users = User::where('role', '!=', 0)->get();
            foreach($users as $key => $user){
                    $user->notify(new AnnouncementNotification($announcement->id, $content, $route_name));
            }

        }else{
            $this->announcement_saved_success = 'Failed, please try again later.';
        }

        $this->reset('announcement_name');
        $this->reset('announcement_description');
        $this->reset('announcement_when');
    }

    public function saveEvents()
    {
        $this->validate([
            'event_name' => 'required',
            'description' => 'required',
            'when' => 'required',
            'where' => 'required'
        ]);

        if(Gate::allows('admin')){
            $event = Events::create([
                'event_name' => $this->event_name,
                'description' => $this->description,
                'when' => $this->when,
                'where' => $this->where,
            ]);
            $this->events_saved_success = 'Events saved successful';
            $route_name = 'employee.eventsandnews';
            $content = 'event';
            $users = User::where('role', '!=', 0)->get();
            foreach($users as $key => $user){
                    $user->notify(new EventNotification($event->id, $content, $route_name));
            }
        }else{
            $this->events_saved_success = 'Events saved successful';
        }
       

        $this->reset('event_name');
        $this->reset('description');
        $this->reset('when');
        $this->reset('where');

        
    }

    public function showModal()
    {
        $this->addModal = true;
        $this->addModalContent = 'events';
    }

    public function events()
    {
        $this->addModalContent = 'events';
    }

    public function announcements()
    {
        $this->addModalContent = 'announcements';
    }

    public function render()
    {
        $date = date('Y-m-d', time());
        $this->events_happening_now = Events::where('when', $date)->get();
        $this->announcement_happening_now = ModelsAnnouncements::where('when', $date)->get();
     


        $this->incomming_events = Events::where('when', '!=', $date)
                                            ->where('status', 'pending')->get();
        $this->incomming_announcements = ModelsAnnouncements::where('when', '!=', $date)
                                        ->where('status', 'pending')->get();
        

        
        $this->past_events = Events::where('status', 'done')->get();                                
        $this->past_announcements = ModelsAnnouncements::where('status', 'done')->get();                                

        


        return view('livewire.users.hrofficer.announcements');


    }
}
