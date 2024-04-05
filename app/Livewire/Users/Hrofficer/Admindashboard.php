<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\Announcements;
use App\Models\Events;
use App\Models\Jobs;
use App\Models\TrainingsAvailable;
use App\Models\User;
use App\Notifications\HappeningNowAnnouncementNotification;
use App\Notifications\HappeningNowEventNotification;
use App\Notifications\TrainingEndedNotification;
use App\Notifications\TrainingStartNotification;
use Livewire\Component;

class Admindashboard extends Component
{
    public $userExtend = false;
    public $content;

   public function mount()
   {
    $training_availables = TrainingsAvailable::orderBy('created_at', 'desc')->get();
        foreach ($training_availables as $key => $value) {
            if($value->status == 'pending'){
                $date = explode('-', $value->start_date);
                $t_yr = $date[0];
                $t_month = $date[1];
                $t_day = $date[2];

                $yr = date('Y', time());
                $month = date('m', time());
                $day = date('d', time());

                if($t_yr == $yr){
                    if($t_month == $month){
                        if($t_day == $day){
                            $value->status = 'On Going';
                            $value->save();
                            $route_name = "employee.training";
                            $content = "TRAININGS";
                                foreach($value->approved_applicants  as $key => $participant){
                                    $prtcpnt = User::where('employee_id', $participant->employee_id)->first();
                                    $prtcpnt->notify(new TrainingStartNotification($prtcpnt->employee_id, $value->id, $value->training_name, $content, $route_name));
                                    $prtcpnt->status = 'On Training';
                                    $prtcpnt->save();
                                }
                            $admin = User::where('role', 2)->first();    
                            $admin->notify(new TrainingStartNotification($admin->employee_id, $value->id, $value->training_name, $content, $route_name));
                        }
                    }
                }

            }else{
                continue;
            }

        }


        $trainings = TrainingsAvailable::where('status', 'On Going')->get();
        if($trainings != null){
            $route_name = "employee.training";
            $content = "TRAININGS";
            foreach($trainings as $training){
                if(date('Y-m-d', time()) >= $training->to_date){
                            $training->status = 'Ended';
                            $training->save();

                    foreach($training->approved_applicants as $key => $applicant){
                        $user = User::where('employee_id', $applicant->employee_id)->first();
                        $user->notify(new TrainingEndedNotification($applicant->user->employee_id, $training->id,$training->training_name, $content, $route_name));
                        $user->status = 'Active';
                        $user->save();
                    } 
                    
                $admins = User::where('role', 2)->get();
                foreach($admins as $key => $admin){
                $admin->notify(new TrainingEndedNotification($admin->employee_id, $training->id,$training->training_name, $content, $route_name));
            }
                }
            }

            
        }

        //EVENTS AND ANNOUNCEMENTS
        $date = date('Y-m-d', time());
        $events_happening_now = Events::where('when', $date)->get();
        $announcement_happening_now = Announcements::where('when', $date)->get();
        $route_name = 'employee.eventsandnews';
        $announcement_content = 'announcement_happening_now';
        $event_content = 'event_happening_now';
        $users = User::where('role', '!=', 0)->get();
        if ($events_happening_now) {
            foreach ($events_happening_now as $key => $event) {
                if ($event->status != 'happening now') {
                    $event->status = 'happening now';
                    $event->save();
                    foreach ($users as $key => $user) {
                        $user->notify(new HappeningNowEventNotification($event->id, $event->event_name, $event_content, $route_name));
                    }
                }
            }
        }

        if ($announcement_happening_now) {
            foreach ($announcement_happening_now as $key => $announcement) {
                if ($announcement->status != 'happening now') {
                    $announcement->status = 'happening now';
                    $announcement->save();
                    foreach ($users as $key => $user) {
                        $user->notify(new HappeningNowAnnouncementNotification($announcement->id, $announcement->announcement_name, $announcement_content, $route_name));
                    }
                }
            }
        }

        $events = Events::all();
        if ($events) {
            foreach ($events as $key => $value) {
                if((strtotime("$value->when") - strtotime($date)) < 0){
                    if ($value->status != 'done') {
                        $value->status = 'done';
                        $value->save();
                    }
                }
            }
        }

        $announcements = Announcements::all();
        if ($announcements) {
            foreach ($announcements as $key => $value) {
                if((strtotime("$value->when") - strtotime($date)) < 0){
                    if ($value->status != 'done') {
                        $value->status = 'done';
                        $value->save();
                    }
                }
            }
        }
   
    $jobs = Jobs::where('status', 'On Going')->get();  
    $time = time();
    $date = date('Y-m-d', $time);
        if($jobs != null){
            foreach($jobs as $job){
                $hiring_limit = explode('/', $job->hiring_limit);
                if($job->hiring_closing_date == $date || $hiring_limit[0] >= $hiring_limit[1]){
                    $job->status = 'Closed';
                    $job->save();
                }
            }
        }
    }

    public function userextend()
    {
       if($this->userExtend == false){
        $this->userExtend = true;
       }else if($this->userExtend == true){
        $this->userExtend = false;

       }
    }
    
    public function render()
    {
        

        return view('livewire.users.hrofficer.admindashboard');
    }
}
