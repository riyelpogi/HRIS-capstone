<?php

namespace App\Livewire\Users\Employee\Attendance;

use App\Models\April;
use App\Models\August;
use App\Models\December;
use App\Models\DtrTicket;
use App\Models\February;
use App\Models\InandOut;
use App\Models\January;
use App\Models\July;
use App\Models\June;
use App\Models\March;
use App\Models\May;
use App\Models\November;
use App\Models\October;
use App\Models\September;
use App\Models\User;
use App\Notifications\TicketsNotification;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class DailyTimeRecord extends Component
{
    use WithFileUploads;
    public $month = '';
    public $dtr;
    public $year;
    public $dtrModal = false;
    
    #[Rule('required')]
    public $date;
    #[Rule('required')]
    public $time;
    #[Rule('required|mimes:jpeg,jpg,png,bng,img,image')]
    public $proof;
    #[Rule('required')]
    public $inorout;
    public $content = '';
    public $tickets;
    public $showImage = false;
    public $image;
    public $schedules;
    public $total_days;
    public $num;
    public $arr;
    public $ticket_id;
    public function mount($id, $content)
    {
        $this->ticket_id = $id;
        $this->content = $content;
    }

    public function showImageModal($file_name)
    {
        $this->image = $file_name;
        $this->showImage = true;
    }

    public function cancelMyTicket($id)
    {
        $ticket = DtrTicket::find($id);
        
        if($ticket != null){
                if(Gate::allows('cancel-dtr-ticket', $ticket)){
                $ticket->status = 'canceled';
                $ticket->reason_to_decline = 'This user canceled this ticket';
                $ticket->save();
                session()->flash('success', 'Ticket canceled.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }

    public function showDtr()
    {
        $this->content = 'DTR';
    }

    public function showMyTickets()
    {
        $this->content = 'MYTICKETS';
    }
    public function dtrticketsubmit()
    {
        $this->validate([
            'date' => 'required',
            'time' => 'required',
            'inorout' => 'required',
            'proof' => 'required|mimes:jpeg,jpg,png,bng,img,image'
        ]);
        
        if(Gate::allows('employee')){
                    $file_name = $this->proof->getClientOriginalName();
                    $this->proof->storeAs('/public/employee-ticket/'.$file_name);

                    $ticket = DtrTicket::create([
                        'employee_id' => auth()->user()->employee_id,
                        'date' => $this->date,
                        'time' => $this->time,
                        'inorout' => $this->inorout,
                        'file_name' => $file_name
                    ]);

                   if($ticket != null){
                        $admin = User::where('role', 2)->first();
                        if($admin != null){
                            $content = 'TICKETS';
                            $route_name = "admin.employee.inandout";
                            $admin->notify(new TicketsNotification(auth()->user()->employee_id, $route_name, $content));
                            session()->flash('success', 'Successful');
                        }
                   }else{
                    session()->flash('failed', 'Failed, please try again later.');
                    }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        $this->reset('proof');
        $this->reset('date');
        $this->reset('time');
        $this->reset('inorout');
        $this->reset('dtrModal');


    }
    public function showDtrModal()
    {
        $this->dtrModal = true;
    }
    public function render()
    {
        if($this->content == null){
            $this->content = 'DTR';
        }

        if($this->year == null){
            $this->year = date('Y', time());
        }

        if($this->month != null){
            
             $this->dtr = InandOut::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)
                                    ->where('month', $this->month)
                                    ->orderBy('date', 'desc')->get();
        }else{
            $this->month = date('n', time());
            $this->dtr = InandOut::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)
                                    ->where('month', date('n', time()))
                                    ->orderBy('date','desc',)->get();
        }

        if($this->month == 1){
            $sched = January::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 2){
            $sched = February::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 3){
            $sched = March::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 4){
            $sched = April::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 5){
            $sched = May::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 6){
            $sched = June::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 7){
            $sched = July::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 8){
            $sched = August::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 9){
            $sched = September::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 10){
            $sched = October::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 11){
            $sched = November::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 12){
            $sched = December::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }

        $total_days = cal_days_in_month(CAL_GREGORIAN, $this->month, date('Y', time()));
        foreach($this->dtr as $record){
            //checking if the record is time in
                if($record->inorout == "IN"){
                    //checking if status == null
                    if($record->status == null){
                        //assigning the date time in to a day variable
                        $day = $record->date;
                        //if the schedule is not equal on this the code must run
                        if($sched->$day != 'On Training' && $sched->$day != 'On Leave' && $sched->$day != 'Leave' && $sched->$day != 'RD' && $sched->$day != 'On Sick Leave' && $sched->$day != 'On Maternity Leave'){
                        $arr = explode('-', $sched->$day);
                        $in = trim($arr[0]);
                        $time_in = substr($record->time,0, strlen($record->time) - 2);
                        $time_sched = substr($in,0, strlen($in) - 2);
                        $time_sched_meridiem = substr($in, strlen($in) - 2);
                        $time_in_meridiem = substr($record->time, strlen($record->time) - 2);
                        if($time_in_meridiem == $time_sched_meridiem){
                            $a = explode(':', $time_in);
                            $b = explode(':', $time_sched);
                            if($a[0] > $b[0]){
                                 $record->status = 'LATE';
                            }else if($b[0] >= $a[0]){
                                $record->status = 'ON TIME';
                            }
                        }elseif($time_in_meridiem == 'pm' && $time_sched_meridiem == 'am'){
                            $record->status = 'LATE';
                        }else{
                            $record->status = 'LATE';

                        }
                    }

                        $record->save();

                    }
                }elseif($record->inorout == 'OUT'){
                    if($record->status == null){
                            //employee schedule
                            $day = $record->date;
                            if($sched->$day != 'On Training' && $sched->$day != 'On Leave' && $sched->$day != 'Leave' && $sched->$day != 'RD' && $sched->$day != 'On Sick Leave' && $sched->$day != 'On Maternity Leave'){
                            $arr_sched = explode(' - ', $sched->$day);
                            $sched_out = $arr_sched[1];
                            $sched_out_time = substr($sched_out, 0 , 1);
                            $sched_merediem = substr($sched_out, strlen($sched_out) - 2); 

                        //employee out
                        $employee_out = explode(':',$record->time);
                        $employee_out_merediem = substr($employee_out[1], strlen($employee_out[1]) - 2);
                        $employee_out_time = $employee_out[0];
                        if($sched_merediem  == $employee_out_merediem){
                            if($sched_out_time > $employee_out_time){
                                $record->status = 'EARLY OUT';
                            }else if($sched_merediem == 'am' && $employee_out_merediem == 'pm'){
                                if(date('j', time()) == $record->date){
                                 $record->status = 'EARLY OUT';
                                }

                            }
                        }
                        $record->save();

                    }
                }

                }

        }

        $this->tickets = DtrTicket::where('employee_id', auth()->user()->employee_id)
                                    ->orderBy('created_at', 'desc')->take(10)->get();
       
        if($this->month == 1){
            $this->schedules = January::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 2){
            $this->schedules = February::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 3){
            $this->schedules = March::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 4){
            $this->schedules = April::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 5){
            $this->schedules = May::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 6){
            $this->schedules = June::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 7){
            $this->schedules = July::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 8){
            $this->schedules = August::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 9){
            $this->schedules = September::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 10){
            $this->schedules = October::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 11){
            $this->schedules = November::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }else if($this->month == 12){
            $this->schedules = December::where('employee_id', auth()->user()->employee_id)
                            ->where('year', date('Y', time()))->first();
        }

        $this->total_days = cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);

        $this->arr = [];
        for ($i=1; $i <= $this->total_days ; $i++) { 
            if($this->month != null){
            
                $dtr_in = InandOut::where('employee_id', auth()->user()->employee_id)
                                       ->where('year', $this->year)
                                       ->where('month', $this->month)
                                       ->where('date', $i)
                                       ->where('inorout', "IN")
                                       ->orderBy('date', 'desc')
                                       ->take(25)->first();
                                         
                $dtr_out = InandOut::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)
                                    ->where('month', $this->month)
                                    ->where('date', $i)
                                    ->where('inorout', "OUT")
                                    ->orderBy('date', 'desc')
                                    ->take(25)->first();
           }else{
               $this->month = date('n', time());
               $dtr_out = InandOut::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)
                                    ->where('month', date('n', time()))
                                    ->where('date', $i)
                                    ->where('inorout', "OUT")
                                    ->orderBy('date','desc',)
                                    ->take(25)->first();

            $dtr_out = InandOut::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $this->year)
                                ->where('month', date('n', time()))
                                ->where('date', $i)
                                ->where('inorout', "OUT")
                                ->orderBy('date','desc',)
                                ->take(25)->first();                     
           }


            if($dtr_in != null){
                if($dtr_in->inorout == "IN"){
                    if (strpos($this->schedules->$i, '-')) {
                        $schedule = explode('-', $this->schedules->$i);
                            if(!in_array($i.'-in', $this->arr)){
                                $this->arr[$i.'-in'] = [
                                    'schedule' => $schedule[0],
                                    'employee_id' => $dtr_in->employee_id,
                                    'date' => $dtr_in->year . '/' . $dtr_in->month . '/' . $dtr_in->date,
                                    'inorout' => $dtr_in->inorout,
                                    'time' => $dtr_in->time,
                                    'status' => $dtr_in->status
                                ];
                            }
                    }
                    
            }
            }

            if($dtr_out != null){
                 if($dtr_out->inorout == "OUT"){
                            if(strpos($this->schedules->$i, '-')){
                                $schedule = explode('-', $this->schedules->$i);
                            if(!in_array($i.'-out', $this->arr)){
                                $this->arr[$i.'-out'] = [
                                    'schedule' => $schedule[1],
                                    'employee_id' => $dtr_out->employee_id,
                                    'date' => $dtr_out->year . '/' . $dtr_out->month . '/' . $dtr_out->date,
                                    'inorout' => $dtr_out->inorout,
                                    'time' => $dtr_out->time,
                                    'status' => $dtr_out->status
                                ];
                            }
                            }
                    }
            }

            }

        return view('livewire.users.employee.attendance.daily-time-record');
    }
}
