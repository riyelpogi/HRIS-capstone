<?php

namespace App\Livewire\Users\Employee\Attendance;

use App\Models\April;
use App\Models\August;
use App\Models\December;
use App\Models\February;
use App\Models\January;
use App\Models\July;
use App\Models\June;
use App\Models\Leave;
use App\Models\LeaveRequests;
use App\Models\March;
use App\Models\May;
use App\Models\November;
use App\Models\October;
use App\Models\RequestOff;
use App\Models\RequestSchedule;
use App\Models\September;
use App\Models\CoeRequest;
use App\Models\User;
use App\Notifications\ChangeDayOffNotification;
use App\Notifications\LeaveRequestNotification;
use App\Notifications\ScheduleRequestNotification;
use App\Notifications\CoeNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Attributes\Validate;

class Schedule extends Component
{
    #[Rule('required')]
    public $date;

    #[Rule('required')]
    public $reason;
    #[Rule('required')]
    public $rest_day;

    public $content;
    public $month = '';
    public $total_days;
    public $year;
    public $schedule = '';
    public $numericMonthSchedule;
    

    protected $listeners = ['refreshComponent' => '$refresh'];
    
    public $requestOffModal = false;

    public $attendance_content;

    public $requestsOffs;
    public $request_schedules;

    public $requestScheduleModal = false;
    public $requestScheduleMonth;
    public $requestScheduleDate;
    public $total_days_request;
    public $numericMonth;

    public $request_leaves;
    public $showRequestmodal = false;

    #[Rule('required')]
    public $reason_request_leave = '';
    #[Rule('required')]
    public $from;
    #[Rule('required')]
    public $to;

    #[Rule('required')]
    public $cutoff;
    public $monthNow;
    public $cutofflists = [];
    public $setScheduleModal = false;

    #[Rule('required')]
    public $Mon;
    #[Rule('required')]
    public $Tue;
    #[Rule('required')]
    public $Wed;
    #[Rule('required')]
    public $Thu;
    #[Rule('required')]
    public $Fri;
    #[Rule('required')]
    public $Sat;
    #[Rule('required')]
    public $Sun;

    public $request_content;
    public $rest_days = [];
    public $parameter_id;
    public $coerequestmodal = false;

    #[Rule('required')]
    public $coe_for;
    public $coe_requests;

    public function downloadCoe($file)
    {
        if(File::exists(public_path($file))){
           
            return response()->download(public_path($file));
        }else{
            session()->flash('failed', 'File not exists');
        }
    }

    public function cancelCoeRequest($id)
    {
        $request = CoeRequest::find($id);
        if($request != null){
            if(auth()->user()->employee_id == $request->employee_id){
                $request->status = 'canceled';
                $request->save();
                session()->flash('success', 'Cancel successful');
            }else{
            session()->flash('failed', 'Failed, please try again');
            }
        }else{
            session()->flash('failed', 'Failed, please try again');
        }
    }

    public function showRequestCoe()
    {
        $this->request_content = 'COEREQUEST';
    }
    public function submitRequestCoe()
    {
        $this->validate([
            'coe_for' => 'required|max:100'
        ]);

        if(auth()->user()->deployed!= null){
            $request = CoeRequest::create([
                'employee_id' => auth()->user()->employee_id,
                'name' => auth()->user()->name,
                'position' => auth()->user()->position,
                'for' => $this->coe_for
            ]);
            $admins = User::where('role', 2)->get();
            if($admins != null){
                $content = 'COEREQUEST';
                $route_name = "admin.employees.requests";
                foreach($admins as $key => $admin){
                    $admin->notify(new CoeNotification(auth()->user()->employee_id, $route_name, $content));
                }
              
            }
            $this->reset('coerequestmodal');
            $this->reset('coe_for');
            session()->flash('success', 'Request successful.');
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }
    public function requestCoe()
    {
        $this->coerequestmodal = true;
    }

    public function mount($id, $content, $contentofcontent)
    {
        if($content != null){
            $this->attendance_content = $content;
        }
        if($contentofcontent != null){
            $this->request_content = $contentofcontent;
        }

        if($id != null){
            $this->parameter_id = $id;  
        }
    }

    public function cancelRequestSchedule($id)
    {
        $request = RequestSchedule::find($id);
        
        if(Gate::allows('cancel-schedule-request', $request)){
            if($request != null){
                $request->status = 'canceled';
                $request->save();
                session()->flash('success', 'You successfully canceled the ticket.');
    
            }else{
                session()->flash('failed', 'You do not have a rights to canceled this request.');
            }
        }else{
            session()->flash('failed', 'You do not have a rights to canceled this request.');
        }
        
    }

    public function requestContentSchedule()
    {
        $this->request_content = 'SCHEDULE';
    }

    public function requestContentLeave()
    {
        $this->request_content = 'LEAVE';
    }

    public function requestContentOff()
    {
        $this->request_content = 'OFF';
    }

    public function setSchedule()
    {
        $this->validate([
            'Mon' => 'required',
            'Tue' => 'required',
            'Wed' => 'required',
            'Thu' => 'required',
            'Fri' => 'required',
            'Sat' => 'required',
            'Sun' => 'required',
        ]);

        if(Gate::allows('employee')){
            $request_schedule = RequestSchedule::create([
                'employee_id' => auth()->user()->employee_id,
                'cutoff' => $this->cutoff,
                'Mon' => $this->Mon,
                'Tue' => $this->Tue,
                'Wed' => $this->Wed,
                'Thu' => $this->Thu,
                'Fri' => $this->Fri,
                'Sat' => $this->Sat,
                'Sun' => $this->Sun,
            ]);
    
           if($request_schedule){
            $cutoff = explode('to', $request_schedule->cutoff);
            $a = explode('-', $cutoff[0]);
            $month = $a[1];
            $year = $a[0];
            if ($month == 1) {
                $sched = January::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 2){
                $sched = February::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 3){
                $sched = March::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 4){
                $sched = April::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 5){
                $sched = May::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 6){
                $sched = June::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 7){
                $sched = July::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 8){
                $sched = August::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 9){
                $sched = September::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 10){
                $sched = October::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 11){
                $sched = November::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }else if($month == 12){
                $sched = December::where('employee_id', auth()->user()->employee_id)
                                ->where('year', $year)->first();
            }
    
            if($sched == null){
               if($month == 1){
                    $sched = January::create([
                        'employee_id' => auth()->user()->employee_id,
                        '1' => 'RH',
                        'year' => $year
                    ]);
                }elseif($month == 2){
                    $sched = February::create([
                        'employee_id' => auth()->user()->employee_id,
                        '10' => 'SNWH',
                        'year' => $year
                    ]);
                }elseif($month == 3){
                    $sched = March::create([
                        'employee_id' => auth()->user()->employee_id,
                        '28' => 'RH',
                        '29' => 'RH',
                        '30' => 'SNWH',
                        'year' => $year
                    ]);
                }elseif($month == 4){
                    $sched = April::create([
                        'employee_id' => auth()->user()->employee_id,
                        '9' => 'RH',
                        '10' => 'RH',
                        'year' => $year
                    ]);
                }elseif($month == 5){
                    $sched = May::create([
                        'employee_id' => auth()->user()->employee_id,
                        '1' => 'RH',
                        'year' => $year
                    ]);
                }elseif($month == 6){
                    $sched = June::create([
                        'employee_id' => auth()->user()->employee_id,
                        '12' => 'RH',
                        'year' => $year
                    ]);
                }elseif($month == 7){
                    $sched = July::create([
                        'employee_id' => auth()->user()->employee_id,
                        'year' => $year
                    ]);
                }elseif($month == 8){
                    $sched = August::create([
                        'employee_id' => auth()->user()->employee_id,
                        '21' => 'SNWH',
                        '26' => 'RH',
                        'year' => $year
                    ]);
                }elseif($month == 9){
                    $sched = September::create([
                        'employee_id' => auth()->user()->employee_id,
                        'year' => $year
                    ]);
                }elseif($month == 10){
                    $sched = October::create([
                        'employee_id' => auth()->user()->employee_id,
                        'year' => $year
                    ]);
                }elseif($month == 11){
                    $sched = November::create([
                        'employee_id' => auth()->user()->employee_id,
                        '1' => 'SNWH',
                        '2' => 'SNWH',
                        '30' => 'RH',
                        'year' => $year
                    ]);
                }elseif($month == 12){
                    $sched = December::create([
                        'employee_id' => auth()->user()->employee_id,
                        '8' => 'SNWH',
                        '24' => 'SNWH',
                        '25' => 'RH',
                        '30' => 'RH',
                        '31' => 'SNWH',
                        'year' => $year
                    ]);
                }
            }
            
            $admins = User::where('role', 2)->get();
            if($admins != null){
                $content = 'SCHEDULE';
                $route_name = "admin.employees.requests";
                foreach($admins as $key => $admin){
                    $admin->notify(new ScheduleRequestNotification(auth()->user()->employee_id, $route_name, $content));
                }
            }
    
            session()->flash('success', 'Request successful.');
    
           }else{
            session()->flash('failded', 'Failed, please try again later.');
            
           }
        }else{
            session()->flash('failded', 'Failed, please try again later.');
            
           }
        $this->setScheduleModal = false;


    }

    public function cutoffsave()
    {
        $this->validate([
            'cutoff' => 'required'
        ]);
        $this->requestScheduleModal = false;
        $this->setScheduleModal = true;
    }

    public function cancelRequestLeave($id)
    {
        $leave = LeaveRequests::find($id);
        if($leave != null){
            if(Gate::allows('cancel-leave-request', $leave)){
                $leave->status = 'canceled';
                $leave->save();
            session()->flash('success', 'Canceled successful.');
    
            }else{
            session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
            }
    }

    public function submitRequestleave()
    {
        $this->validate([
            'from' => 'required',
            'to' => 'required',
            'reason_request_leave' => 'required'
        ]);        

        if(Gate::allows('employee')){
            $from = explode('-', $this->from);
            $from_yr = $from[0];
            $from_month = $from[1];
            $from_day = $from[2];

            $to = explode('-', $this->to);
            $to_yr = $to[0];
            $to_month = $to[1];
            $to_day = $to[2];
            $date = date('Y-m-d', time());
            $date_arr = explode('-', $date);
            $date_yr = $date_arr[0];
            $date_month = $date_arr[1];
            $date_day = $date_arr[2];
            
            if($from_yr >= $date_yr){
                if($from_month == $date_month && $to_month == $date_month){
                    if(($from_day >= $date_day && $to_day >= $from_day)){
                    $request_leave = LeaveRequests::create([
                                'employee_id' => auth()->user()->employee_id,
                                'from' => $this->from,
                                'to' => $this->to,
                                'reason' => $this->reason_request_leave
                            ]);
                    
                        if($request_leave){
                            $admins = User::where('role', 2)->get();
                            if($admins != null){
                                $route_name = "admin.employees.requests";
                                $content = "LEAVE";
                                foreach($admins as $key => $admin){
                                    $admin->notify(new LeaveRequestNotification(auth()->user()->employee_id, $route_name, $content));
                                }
                            } 
                    
                            session()->flash('success', 'Request successful.');
                        }else{
                            session()->flash('failed', 'Failed, please try again later.');
                        }
                    }else{
            session()->flash('failed', 'Failed, please try again or check your date request.');
            }   
                }elseif($from_month > $date_month && $to_month > $from_month){
                        $request_leave = LeaveRequests::create([
                            'employee_id' => auth()->user()->employee_id,
                            'from' => $this->from,
                            'to' => $this->to,
                            'reason' => $this->reason_request_leave
                        ]);
                
                    if($request_leave){
                        $admins = User::where('role', 2)->get();
                        if($admins != null){
                            $route_name = "admin.employees.requests";
                            $content = "LEAVE";
                            foreach($admins as $key => $admin){
                                $admin->notify(new LeaveRequestNotification(auth()->user()->employee_id, $route_name, $content));
                            }
                        }   
                
                        session()->flash('success', 'Request successful.');
                    }else{
                        session()->flash('failed', 'Failed, please try again later.');
                    }
                    
                }elseif($from_month == $date_month && $to_month == $from_month){
                        if($from_day <= $to_day){
                            $request_leave = LeaveRequests::create([
                                'employee_id' => auth()->user()->employee_id,
                                'from' => $this->from,
                                'to' => $this->to,
                                'reason' => $this->reason_request_leave
                            ]);
                    
                        if($request_leave){
                            $admins = User::where('role', 2)->get();
                            if($admins != null){
                                $route_name = "admin.employees.requests";
                                $content = "LEAVE";
                                foreach($admins as $key => $admin){
                                    $admin->notify(new LeaveRequestNotification(auth()->user()->employee_id, $route_name, $content));
                                }
                            }   
                    
                            session()->flash('success', 'Request successful.');
                        }else{
                            session()->flash('failed', 'Failed, please try again later.');
                        }
                        }else{
                            session()->flash('failed', 'Failed, please try again or check your date request.');
                            }
                    }elseif($from_month == $date_month && $to_month >= $from_month){
                            $request_leave = LeaveRequests::create([
                                'employee_id' => auth()->user()->employee_id,
                                'from' => $this->from,
                                'to' => $this->to,
                                'reason' => $this->reason_request_leave
                            ]);
                    
                        if($request_leave){
                            $admins = User::where('role', 2)->get();
                            if($admins != null){
                                $route_name = "admin.employees.requests";
                                $content = "LEAVE";
                                foreach($admins as $key => $admin){
                                    $admin->notify(new LeaveRequestNotification(auth()->user()->employee_id, $route_name, $content));
                                }
                            }   
                    
                            session()->flash('success', 'Request successful.');
                        }else{
                            session()->flash('failed', 'Failed, please try again later.');
                        }
                        
                }elseif($from_month > $date_month && $to_month == $from_month){
                   if($from_day <= $to_day){
                    $request_leave = LeaveRequests::create([
                        'employee_id' => auth()->user()->employee_id,
                        'from' => $this->from,
                        'to' => $this->to,
                        'reason' => $this->reason_request_leave
                    ]);
            
                if($request_leave){
                    $admins = User::where('role', 2)->get();
                    if($admins != null){
                        $route_name = "admin.employees.requests";
                        $content = "LEAVE";
                        foreach($admins as $key => $admin){
                            $admin->notify(new LeaveRequestNotification(auth()->user()->employee_id, $route_name, $content));
                        }
                    }   
            
                    session()->flash('success', 'Request successful.');
                }else{
                    session()->flash('failed', 'Failed, please try again later.');
                }
                
                   }else{
                       
                    session()->flash('failed', 'Failed, please try again or check your date request.');
                   
                   }
                 }else{
                    session()->flash('failed', 'Failed, please try again or check your date request.');
                    }
            }else{
            session()->flash('failed', 'Failed, please try again or check your date request.');
            }
        
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }


        $this->reset('from');
        $this->reset('to');
        $this->reset('reason_request_leave');
        $this->reset('showRequestmodal');
    }

    public function requestLeave()
    {
        $this->showRequestmodal = true;
    }

    public function showRequestScheduleModal()
    {
        $this->requestScheduleModal = true;
    }

    public function cancelRequestOff($id)
    {
        $requests = RequestOff::find($id);
        if($requests != null){
            if(Gate::allows('cancel-off-request', $requests)){
                $requests->status = 'canceled';
                $requests->save();
                session()->flash('success', 'Canceled successful.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        $this->dispatch('refreshComponent');

    }

    public function updated($propertyName) {
        $this->validateOnly($propertyName);
        }

    public function requestOffSubmit()
    {
        $this->validate([
            'date' => 'required',
            'reason' => 'required',
            'rest_day' => 'required'
        ]);

        if(Gate::allows('employee')){
            $from = explode('-', $this->date);
            $from_yr = $from[0];
            $from_month = $from[1];
            $from_day = $from[2];
            $date = date('Y-m-d', time());
            $date_arr = explode('-', $date);
            $date_yr = $date_arr[0];
            $date_month = $date_arr[1];
            $date_day = $date_arr[2];
            
            if($from_yr >= $date_yr){
                if($from_month == $date_month){
                    if($from_day >= $date_day){ 
                        $requestoff = RequestOff::create([
                            'employee_id' => auth()->user()->employee_id,
                            'date' => $this->date,
                            'reason' => $this->reason,
                            'rest_day' => $this->rest_day
                        ]);
                        if($requestoff){
                                $admins = User::where('role', 2)->get();
                                if($admins != null){
                                    $route_name = "admin.employees.requests";
                                    $content = 'OFF';
                                foreach($admins as $key => $admin){
                                        $admin->notify(new ChangeDayOffNotification(auth()->user()->employee_id, $route_name, $content));
                                    }
                                }
                         session()->flash('success', 'Request successful.');
                
                        }else{
                            session()->flash('failed', 'Failed please try again later.');
                        }
                    }else{
                        session()->flash('failed', 'Failed, please try again or check your date request.');
                        }
                }elseif($from_month > $date_month){
                    $requestoff = RequestOff::create([
                        'employee_id' => auth()->user()->employee_id,
                        'date' => $this->date,
                        'reason' => $this->reason,
                        'rest_day' => $this->rest_day
                    ]);
                    if($requestoff){
                        $admins = User::where('role', 2)->get();
                        if($admins != null){
                            $route_name = "admin.employees.requests";
                            $content = 'OFF';
                        foreach($admins as $key => $admin){
                                $admin->notify(new ChangeDayOffNotification(auth()->user()->employee_id, $route_name, $content));
                            }
                        }
                     session()->flash('success', 'Request successful.');
            
                    }else{
                        session()->flash('failed', 'Failed please try again later.');
                    }
                }else{
                    session()->flash('failed', 'Failed, please try again or check your date request.');
                    }
            }else{
                session()->flash('failed', 'Failed, please try again or check your date request.');
                }
            
        }else{
            session()->flash('failed', 'Failed please try again later.');
        }
        
        $this->reset('requestOffModal');
        $this->reset('date');
        $this->reset('reason');
        $this->reset('rest_day');

    }

    public function requestOff()
    {
        $schedules = [];
        $total_days = 0;
        $month = date('n', time());
        $yr = date('Y', time());
        if($month != 12){
            $total_month = $month + 1;
                for ($i=$month; $i <= $total_month; $i++) { 
                    $day = 1;
                    if($i == $month){
                        $day = date('j', time());
                    }
                    if ($i == 1) {
                        $schedules = January::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 1, date('Y', time()));
                    }else if($i == 2){
                        $schedules = February::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 2, date('Y', time()));
                    }else if($i == 3){
                        $schedules = March::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 3, date('Y', time()));
                    }else if($i == 4){
                        $schedules = April::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 4, date('Y', time()));
                    }else if($i == 5){
                        $schedules = May::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 5, date('Y', time()));
                    }else if($i == 6){
                        $schedules = June::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 6, date('Y', time()));
                    }else if($i == 7){
                        $schedules = July::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 7, date('Y', time()));
                    }else if($i == 8){
                        $schedules = August::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 8, date('Y', time()));
                    }else if($i == 9){
                        $schedules = September::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 8, date('Y', time()));
                    }else if($i == 10){
                        $schedules = October::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 10, date('Y', time()));
                    }else if($i == 11){
                        $schedules = November::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 11, date('Y', time()));
                    }else if($i == 12){
                        $schedules = December::where('employee_id', auth()->user()->employee_id)
                                            ->where('year', $yr)->first();
                        $total_days = cal_days_in_month(CAL_GREGORIAN, 12, date('Y', time()));
                    }
            
                    if($schedules != null){
                        for ($a=$day; $a <= $total_days; $a++) { 
                            if ($schedules->$a == 'RD') {
                                $rd_date = $schedules->year.'-'.$i.'-'.$a;
                                if(!in_array($rd_date, $this->rest_days)){
                                    array_push($this->rest_days, $rd_date);
                                }
                            }
                        }
                    }
            }
        }


        $this->requestOffModal = true;
    }

    public function requests()
    {
        $this->attendance_content = 'REQUESTS';
        $this->dispatch('refreshComponent');

    }

    
    public function schedule_content()
    {
        $this->attendance_content = 'SCHEDULE';
        $this->dispatch('refreshComponent');

    }

    public function jan()
    {
        $this->month = 'January';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 1 , $this->year);
        $this->schedule = January::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function feb()
    {
        $this->month = 'February';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 2 , $this->year);
        $this->schedule = February::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function mar()
    {
        $this->month = 'March';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 3 , $this->year);
        $this->schedule = March::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function apr()
    {
        $this->month = 'April';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 4 , $this->year);
        $this->schedule = April::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function may()
    {
        $this->month = 'May';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 5 , $this->year);
        $this->schedule = May::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function jun()
    {
        $this->month = 'June';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 6 , $this->year);
        $this->schedule = June::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function jul()
    {
        $this->month = 'July';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 7 , $this->year);
        $this->schedule = July::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function aug()
    {
        $this->month = 'August';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 8 , $this->year);
        $this->schedule = August::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function sept()
    {
        $this->month = 'September';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 9 , $this->year);
        $this->schedule = September::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
    }

    public function oct()
    {
        $this->month = 'October';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 10 , $this->year);
        $this->schedule = October::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
        time();
    }

    public function dec()
    {
        $this->month = 'December';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 12 , $this->year);
        $this->schedule = December::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
        $this->dispatch('refreshComponent');
    }

    public function nov()
    {
        $this->month = 'November';
        $this->numericMonthSchedule = date('m', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, 11, $this->year);
        $this->schedule = November::where('employee_id', auth()->user()->employee_id)
                                    ->where('year', $this->year)->first();
        $this->dispatch('refreshComponent');

    }

    public function setYear($id)
    {
        $this->year = $id;
        if ($this->month == "January") {
            $this->schedule = January::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 1, date('Y', time()));
        }else if($this->month == "February"){
            $this->schedule = February::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 2, date('Y', time()));
        }else if($this->month == "March"){
            $this->schedule = March::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 3, date('Y', time()));
        }else if($this->month == "April"){
            $this->schedule = April::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 4, date('Y', time()));
        }else if($this->month == "May"){
            $this->schedule = May::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 5, date('Y', time()));
        }else if($this->month == "June"){
            $this->schedule = June::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 6, date('Y', time()));
        }else if($this->month == "July"){
            $this->schedule = July::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 7, date('Y', time()));
        }else if($this->month == "August"){
            $this->schedule = August::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 8, date('Y', time()));
        }else if($this->month == "September"){
            $this->schedule = September::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 8, date('Y', time()));
        }else if($this->month == "October"){
            $this->schedule = October::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 10, date('Y', time()));
        }else if($this->month == "November"){
            $this->schedule = November::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 11, date('Y', time()));
        }else if($this->month == "December"){
            $this->schedule = December::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 12, date('Y', time()));
        }
    }
       
    public function render()
    {

        if($this->attendance_content == null){
            $this->attendance_content = "SCHEDULE";
        }
        
        if($this->attendance_content == 'REQUESTS'){
            if($this->request_content == null){
                $this->request_content = 'SCHEDULE';
            }
        }

        if ($this->year == null) {
        $this->year = date('Y', time());
            
        }
        

        if ($this->month == null) {
            $this->month = date('F', time());
        $month = date('n', time());
        $this->total_days = cal_days_in_month(CAL_GREGORIAN, $month, date('Y', time()));

        if ($month == 1) {
            $this->schedule = January::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 1, date('Y', time()));
        }else if($month == 2){
            $this->schedule = February::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 2, date('Y', time()));
        }else if($month == 3){
            $this->schedule = March::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 3, date('Y', time()));
        }else if($month == 4){
            $this->schedule = April::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 4, date('Y', time()));
        }else if($month == 5){
            $this->schedule = May::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 5, date('Y', time()));
        }else if($month == 6){
            $this->schedule = June::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 6, date('Y', time()));
        }else if($month == 7){
            $this->schedule = July::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 7, date('Y', time()));
        }else if($month == 8){
            $this->schedule = August::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 8, date('Y', time()));
        }else if($month == 9){
            $this->schedule = September::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 8, date('Y', time()));
        }else if($month == 10){
            $this->schedule = October::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 10, date('Y', time()));
        }else if($month == 11){
            $this->schedule = November::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 11, date('Y', time()));
        }else if($month == 12){
            $this->schedule = December::where('employee_id', auth()->user()->employee_id)
                                        ->where('year', $this->year)->first();
            $this->total_days = cal_days_in_month(CAL_GREGORIAN, 12, date('Y', time()));
        }
       }


        $year = date('Y', time());
       
        $this->requestsOffs = RequestOff::where('employee_id', auth()->user()->employee_id)
                                        ->where('status', '!=', 'canceled')
                                        ->orderBy('created_at','desc')->get();
        $this->requestScheduleMonth = date('F', time());
        if($this->requestScheduleMonth == date('F', time())){
            $this->requestScheduleDate = date('d', time());
        }else{
            $this->requestScheduleDate = 1;

        }

        if ($this->requestScheduleMonth == 'January') {
                $this->numericMonth = 1;
        } else if($this->requestScheduleMonth == 'February') {
            $this->numericMonth = 2;
        }else if($this->requestScheduleMonth == 'March') {
            $this->numericMonth = 3;
        }
        else if($this->requestScheduleMonth == 'April') {
            $this->numericMonth = 4;
        }
        else if($this->requestScheduleMonth == 'May') {
            $this->numericMonth = 5;
        }
        else if($this->requestScheduleMonth == 'June') {
            $this->numericMonth = 6;
        }
        else if($this->requestScheduleMonth == 'July') {
            $this->numericMonth = 7;
        }
        else if($this->requestScheduleMonth == 'August') {
            $this->numericMonth = 8;
        }else if($this->requestScheduleMonth == 'September') {
            $this->numericMonth = 9;
        }else if($this->requestScheduleMonth == 'October') {
            $this->numericMonth = 10;
        }else if($this->requestScheduleMonth == 'November') {
            $this->numericMonth = 11;
        }else if($this->requestScheduleMonth == 'December') {
            $this->numericMonth = 12;
        }

        
        $this->total_days_request = cal_days_in_month(CAL_GREGORIAN, $this->numericMonth, $year);

        $this->request_leaves = LeaveRequests::where('employee_id', auth()->user()->employee_id)
                                             ->where('status', '!=', 'canceled')
                                             ->orderBy('created_at','desc')->get();
     
        $this->request_schedules = RequestSchedule::where('employee_id', auth()->user()->employee_id)
                                                    ->where('status', '!=', 'canceled')
                                                    ->orderBy('created_at','desc')->get();
        $this->coe_requests = CoeRequest::where('employee_id', auth()->user()->employee_id)->orderBy('created_at', 'desc')->take(10)->get();
        $this->monthNow = date('n', time());

        $this->cutofflists = [
            $year + '1' => ['first' => "$year-1-1 to $year-1-15",
                    'second' => "$year-1-16 to $year-1-31"],
                    
            $year + '2' =>  ['first' => "$year-2-1 to $year-2-15",
             'second' => "$year-2-16 to $year-2-29"],      

             $year + '3' =>   ['first' => "$year-3-1 to $year-3-15",
             'second' => "$year-3-16 to $year-3-31"], 

             $year + '4' =>   ['first' => "$year-4-1 to $year-4-15",
             'second' => "$year-4-16 to $year-4-30"],
             
             $year + '5' =>   ['first' => "$year-5-1 to $year-5-15",
             'second' => "$year-5-16 to $year-5-31"],
             
             $year + '6' =>   ['first' => "$year-6-1 to $year-6-15",
             'second' => "$year-6-16 to $year-6-30"],

             $year + '7' =>   ['first' => "$year-7-1 to $year-7-15",
             'second' => "$year-7-16 to $year-7-31"],

             $year + '8' =>   ['first' => "$year-8-1 to $year-8-15",
             'second' => "$year-8-16 to $year-8-31"],

             $year + '9' =>   ['first' => "$year-9-1 to $year-9-15",
             'second' => "$year-9-16 to $year-9-30"],

             $year + '10' =>   ['first' => "$year-10-1 to $year-10-15",
             'second' => "$year-10-16 to $year-10-31"],

             $year + '11' =>   ['first' => "$year-11-1 to $year-11-15",
             'second' => "$year-11-16 to $year-11-30"],

             $year + '12' =>   ['first' => "$year-12-1 to $year-12-15",
             'second' => "$year-12-16 to $year-12-31"],

             $year + 1 + '13' => ['first' => $year + 1 . "-1-1 to " . $year + 1 . "-1-15",
                    'second' => $year + 1 . "-1-16 to " . $year + 1 . "-1-31"],
                    
            $year + 1  + '14' =>  ['first' => $year + 1 . "-2-1 to " . $year + 1 . "-2-15",
             'second' => $year + 1 . "-2-16 to " . $year + 1 . "-2-29"],      

             $year + 1 + '15' =>   ['first' => $year + 1 . "-3-1 to " . $year + 1 . "-3-15",
             'second' => $year + 1 . "-3-16 to " . $year + 1 . "-3-31"], 

             $year + 1 + '16' =>   ['first' => $year + 1 . "-4-1 to " . $year + 1 . "-4-15",
             'second' => $year + 1 . "-4-16 to " . $year + 1 . "-4-30"],
             
             $year + 1 + '17' =>   ['first' => $year + 1 . "-5-1 to " . $year + 1 . "-5-15",
             'second' => $year + 1 . "-5-16 to " . $year + 1 . "-5-31"],
             
             $year + 1 + '18' =>   ['first' => $year + 1 . "-6-1 to " . $year + 1 . "-6-15",
             'second' => $year + 1 . "-6-16 to " . $year + 1 . "-6-30"],

             $year + 1 + '19' =>   ['first' => $year + 1 . "-7-1 to " . $year + 1 . "-7-15",
             'second' => $year + 1 . "-7-16 to " . $year + 1 . "-7-31"],

             $year + 1 + '20' =>   ['first' => $year + 1 . "-8-1 to " . $year + 1 . "-8-15",
             'second' => $year + 1 . "-8-16 to " . $year + 1 . "-8-31"],

             $year + 1 + '21' =>   ['first' => $year + 1 . "-9-1 to " . $year + 1 . "-9-15",
             'second' => $year + 1 . "-9-16 to " . $year + 1 . "-9-30"],

             $year + 1 + '22' =>   ['first' => $year + 1 . "-10-1 to " . $year + 1 . "-10-15",
             'second' => $year + 1 . "-10-16 to " . $year + 1 . "-10-31"],

             $year + 1 + '23' =>   ['first' => $year + 1 . "-11-1 to " . $year + 1 . "-11-15",
             'second' => $year + 1 . "-11-16 to " . $year + 1 . "-11-30"],

             $year + 1 + '24' =>   ['first' => $year + 1 . "-12-1 to " . $year + 1 . "-12-15",
             'second' => $year + 1 . "-12-16 to " . $year + 1 . "-12-31"],

        ];

        return view('livewire.users.employee.attendance.schedule');
    }
}
