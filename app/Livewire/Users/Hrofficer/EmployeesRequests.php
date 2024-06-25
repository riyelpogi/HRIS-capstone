<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\April;
use App\Models\August;
use App\Models\December;
use App\Models\February;
use App\Models\January;
use App\Models\July;
use App\Models\June;
use App\Models\LeaveCredit;
use App\Models\LeaveRequests;
use App\Models\March;
use App\Models\May;
use App\Models\November;
use App\Models\October;
use App\Models\CoeRequest;
use App\Models\User;
use App\Models\RequestOff;
use App\Models\RequestSchedule;
use App\Models\September;
use App\Notifications\ApprovedRequest;
use App\Notifications\DeclinedRequest;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;
use PhpOffice\PhpWord\Shared\Converter;

class EmployeesRequests extends Component
{
    public $requests_content = 'SCHEDULE';
    public $pending_leave_requests;
    public $pending_off_requests;
    public $pending_schedule_requests;

    public $schedule_request;
    public $schedule_request_modal = false;
    public $schedule_request_decline_modal = false;
    public $schedule_request_decline_id;
    #[Rule('required')]
    public $decline;

    public $request_off;
    public $request_off_modal = false;
    public $request_off_decline_id;
    public $request_off_decline_modal = false;
    public $decline_request_off;

    public $request_leave_modal = false;
    public $request_leave;
    #[Rule('required')]
    public $request_leave_total_days;

    public $decline_leave_modal = false;
    public $decline_leave_id;
    #[Rule('required')]
    public $decline_leave_reason;
    public $coe_requests;
    #[Rule('required|max:500')]
    public $decline_coe_request;
    public $decline_coe_request_modal = false;
    public $decline_coe_request_id;
    public function declineCoeRequestModal($id)
    {
        $this->decline_coe_request_modal = true;
        $this->decline_coe_request_id = $id;
        
    }
    public function declineCoeRequest()
    {
        $this->validate([
            'decline_coe_request' => 'required|max:500'
        ]);
        $request = CoeRequest::find($this->decline_coe_request_id);
        if($request != null){
            if(Gate::allows('admin')){
                $request->status = 'declined';
                $request->reason_to_decline = $this->decline_coe_request;
                $request->save();
                $user = User::where('employee_id', $request->employee_id)->first();
                if($user != null){
                    $message = 'Your COE request has been declined by the admin with the reason of "' . $this->decline_coe_request . '".';
                    $content = 'REQUESTS';
                    $content_of_content = 'COEREQUEST';
                    $route_name = "employee.schedule";
                    $user->notify(new DeclinedRequest($user->employee_id,$request->id, $content, $content_of_content, $message, $route_name));
                }
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        $this->reset('decline_coe_request');
        $this->reset('decline_coe_request_modal');
        $this->reset('decline_coe_request_id');
    }
    public function approveCoeRequest($id)
    {
        $request = CoeRequest::find($id);
        $head = User::where('role', 1)->where('position', 'Human Resources Head')->first();
        if($request != null){
            if(Gate::allows('admin')){
                $phpword = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpword->addSection();

        $section->addImage('storage/hrislogo/HRIS.png',  [
            'width' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(3),
            'height' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(3),
            'positioning' => \PhpOffice\PhpWord\Style\Image::POSITION_ABSOLUTE,
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
            'posVerticalRel' => \PhpOffice\PhpWord\Style\Image::POSITION_RELATIVE_TO_PAGE,
            'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(10.5),
            'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(1.55),
        ]);
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setName('Times New Roman');
        $fontStyle->setSize(16);
        $fontStyle->setBold(true);
        $name = new \PhpOffice\PhpWord\Style\Font();
        $name->setName('Times New Roman');
        $name->setSize(12);
        $name->setBold(true);
        $textStyle = new \PhpOffice\PhpWord\Style\Font();
        $textStyle->setName('Times New Roman');
        $textStyle->setSize(12);
        $fontStyleHeader = new \PhpOffice\PhpWord\Style\Font();
        $fontStyleHeader->setSize(12);
        $fontStyleHeader->setName('Times New Roman');
        $fontStyleHeader->setBold(true);
        $a = $section->addText('Human Resources Information System');
        $b = $section->addText('Blk 21, Lot 14, Area H, Phase III, Barangay San Rafael V, CSJDM. Bulacan');
        $c = $section->addText('+639922859502 - hrisaonestopemployeemanagementapplication@gmail.com');
        $section->addTextBreak();
        $text = $section->addText('                                               CERTIFICATE OF EMPLOYMENT');
        $text->setFontStyle($fontStyleHeader);
        $a->setFontStyle($fontStyleHeader);
        $b->setFontStyle($fontStyleHeader);
        $c->setFontStyle($fontStyleHeader);
        $d = $section->addText('TO WHOM IT MAY CONCERN');
        $d->setFontStyle($fontStyleHeader);
        $section->addTextBreak();
        $e = $section->addText("This is to certify that ". strtoupper($request->name) . " is an employee of the Company as " . strtoupper($request->position). ".");
        $e->setFontStyle($textStyle);
        $section->addTextBreak();
        $f = $section->addText("As per our record of this office, he/she was employed by the company since " . $request->user->employee_information->deployment_date . " to present.");
        $f->setFontStyle($textStyle);
        $g = $section->addText("This certification is being issued upon the request of the above name employee for " . strtoupper($request->for) . ".");
        $g->setFontStyle($textStyle);
        $section->addTextBreak();
        $h = $section->addText("For Verification purposes, please contact Company Human Resources Office or email hrisaonestopemployeemanagementapplication@gmail.com" . ".");
        $h->setFontStyle($textStyle);
        $section->addTextBreak();
        $i = $section->addText("Issued on " . date('Y-m-d', time()) . ", at the City of San Jose del Monte, Bulacan, Philippines.");
        $i->setFontStyle($textStyle);
        $section->addTextBreak();
        $j = $section->addText('Prepared by:');
        $j->setFontStyle($textStyle);
        $section->addTextBreak();
        $section->addTextBreak();
        $k = $section->addText(strtoupper($head->name) . ' - HR OFFICER ');
        $k->setFontStyle($name);
        $section->addTextBreak();
        $section->addTextBreak();
        $l = $section->addText('Approved by:');
        $section->addTextBreak();
        $section->addTextBreak();
        $m = $section->addText('JHON RIYEL MENTE - PRESIDENT ');
        $m->setFontStyle($name);
        $objWord = \PhpOffice\PhpWord\IOFactory::createWriter($phpword, 'Word2007');
        $fileName = $request->user->name .'- COE - '.date('Y-m-d', time());
        $objWord->save($fileName.'.docx');
        $request->status = 'approved';
        $request->file = $fileName.'.docx';
        $request->save();
        $user = User::where('employee_id', $request->employee_id)->first();
        if($user != null){
            $message = "Your COE request has been approved by the admin.";
            $content = 'REQUESTS';
            $content_of_content = 'COEREQUEST';
            $route_name = "employee.schedule";
            $user->notify(new ApprovedRequest($user->employee_id,$request->id ,$content ,$content_of_content ,$message, $route_name));
        session()->flash('success', 'Request approved.');

        }
            session()->flash('success', 'Approved successful.');
            }else{
            session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');

        }
    }
    public function mount($content)
    {
        if($content != null){
            $this->requests_content = $content;
        }
    }

    public function coe()
    {
        $this->requests_content = 'COEREQUEST';

    }
    public function declineLeaveRequest()
    {
        $this->validate([
            'decline_leave_reason' => 'required'
        ]);

        if(Gate::allows('admin')){
            $request = LeaveRequests::find($this->decline_leave_id);
            if($request != null){
                $request->reason_to_decline = $this->decline_leave_reason;
                $request->status = 'declined';
                $request->save();
                $user = User::where('employee_id', $request->employee_id)->first();
                if($user != null){
                    $message = 'Your leave request has been declined by the admin with the reason of "' . $this->decline_leave_reason . '".';
                    $content = 'REQUESTS';
                    $content_of_content = 'LEAVE';
                    $route_name = "employee.schedule";
                    $user->notify(new DeclinedRequest($user->employee_id,$request->id, $content, $content_of_content, $message, $route_name));
                }
                session()->flash('success', 'Request declined.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        $this->reset('decline_leave_reason');
        $this->reset('decline_leave_modal');

    }

    public function showDeclineLeaveRequestModal($id)
    {
        $this->decline_leave_modal = true;
        $this->decline_leave_id = $id;
        $this->request_leave_modal = false;
    }

    public function leaveRequestApprove()
    {
        
        $this->validate([
            'request_leave_total_days' => 'required'
        ]);

        if(Gate::allows('admin')){
            $from = explode('-', $this->request_leave->from);
            $to = explode('-', $this->request_leave->to);
            $f_month = $from[1];
            $f_year = $from[0];
    
            if($from[2] <= 9){
                $str = strval($from[2]);
                if(strlen($str) == 2){
                    if($str[0] == '0'){
                        $f_day = $str[1];
                    }else{
                        $f_day = $str[0];
                    }
                }else{
                    $f_day = $str[0];
                }
            }else{
                $f_day = $from[2];
    
            }
    
            $t_year = $to[0];
            $t_month = $to[1];
            if($to[2] <= 9){
                $str = strval($to[2]);
                if(strlen($str) == 2){
                    if($str[0] == '0'){
                        $t_day = $str[1];
                    }else{
                        $t_day = $str[0];
                    }
                }else{
                    $t_day = $str[0];
                }
            }else{
                $t_day = $to[2];
            }
           
    
            $user_sched =  [];
            
    
            if ($f_year == $t_year) {
                for($i = $f_month; $i <= $t_month; $i++){
                $count = 0;
    
                        if ($i == 1) {
                            $user_sched = January::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 2){
                            $user_sched = February::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 3){
                            $user_sched = March::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 4){
                            $user_sched = April::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 5){
                            $user_sched = May::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 6){
                            $user_sched = June::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 7){
                            $user_sched = July::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 8){
                            $user_sched = August::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 9){
                            $user_sched = September::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 10){
                            $user_sched = October::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 11){
                            $user_sched = November::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }else if($i == 12){
                            $user_sched = December::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $f_year)->first();
                        }
                        
                        $start_day = 1;
                        $end_day = cal_days_in_month(CAL_GREGORIAN, $i, $f_year);
    
                        if($f_month == $i){
                            $start_day = $f_day;
                        }else if($t_month == $i){
                            $end_day = $t_day;
                        }
                        $holidays = 0;
                        for($a = $start_day; $a <= $end_day; $a++){
                            if(($user_sched->$a != 'On Training') && ($user_sched->$a != 'RH' && $user_sched->$a != 'SNWH')){
                                            $user_sched->$a = 'LEAVE';
                                            $count += 1;
                            }
                            if($user_sched->$a == 'RH' || $user_sched->$a == 'SNWH'){
                                            $count += 1;
                                            $holidays += 1;
                            }

                            
                            if ($count >= $this->request_leave_total_days || $count >= $user_sched->user->leave_credits->leave_credit) {
                                            break;
                            }
                        }
                   
                    
                }     
                $total_count = abs($count - $holidays);
                $user_sched->save();
                $leave_credits = LeaveCredit::where('employee_id', $this->request_leave->employee_id)->first();
                $leave_credits->leave_credit = $leave_credits->leave_credit - $total_count;
                $leave_credits->save();
                $this->request_leave->status = 'approved';
                $this->request_leave->save();
    
                $user = User::where('employee_id', $this->request_leave->employee_id)->first();
                        if($user != null){
                            $message = "Your leave request has been approved by the admin.";
                            $content = 'REQUESTS';
                            $content_of_content = 'LEAVE';
                            $route_name = "employee.schedule";
                            $user->notify(new ApprovedRequest($user->employee_id,$this->request_leave->id ,$content ,$content_of_content ,$message, $route_name));
                        session()->flash('success', 'Request approved.');

                        }

            }else if($t_year > $f_year){
                $count = 0;
                $holidays = 0;
                for($i = $f_year; $i <= $t_year; $i++){
                    $start_month = 1;
                    $end_month = 12;
                    if($i == $f_year){
                        $start_month = $f_month;
                    }elseif($i == $t_year){
                        $end_month = $t_month;
                    }
    
                    
                    for ($a=$start_month; $a <= $end_month ; $a++) { 
                        if ($a == 1) {
                            $user_sched = January::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 2){
                            $user_sched = February::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 3){
                            $user_sched = March::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 4){
                            $user_sched = April::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 5){
                            $user_sched = May::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 6){
                            $user_sched = June::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 7){
                            $user_sched = July::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 8){
                            $user_sched = August::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 9){
                            $user_sched = September::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 10){
                            $user_sched = October::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 11){
                            $user_sched = November::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }else if($a == 12){
                            $user_sched = December::where('employee_id',  $this->request_leave->employee_id)
                                                    ->where('year', $i)->first();
                        }
    
                     $start_days = 1;   
                     $end_days = cal_days_in_month(CAL_GREGORIAN, $a, $i);
                        if($a == $f_month && $i == $f_year){
                            $start_days = $f_day;
                        }else if($a == $t_month && $i == $t_year){
                            $end_days = $t_day;
                        }
    
                        for ($b=$start_days; $b <= $end_days; $b++) { 
                            if($user_sched->$b != 'On Training' && ($user_sched->$b != 'RH' && $user_sched->$b != 'SNWH')){
                                $user_sched->$b = 'LEAVE';
                                $count += 1;
                            }
                            if($user_sched->$b != 'RH' || $user_sched->$b != 'SNWH'){
                                $count += 1;
                                $holidays += 1;
                            }
                            if ($count >= $this->request_leave_total_days || $count >= $user_sched->user->leave_credits->leave_credit) {
                                break;
                            }
                        }
                        $user_sched->save();
                    }
    
                }
                $total_count = abs($holidays - $count);
                    $this->request_leave->status = 'APPROVED';
                    $this->request_leave->save();
                    $leave_credits = LeaveCredit::where('employee_id', $this->request_leave->employee_id)->first();
                    $leave_credits->leave_credit = $leave_credits->leave_credit - $total_count;
                    $leave_credits->save();
                    $user = User::where('employee_id', $this->request_leave->employee_id)->first();
                    if($user != null){
                        $message = "Your leave request has been approved by the admin.";
                        $content = 'REQUESTS';
                        $content_of_content = 'LEAVE';
                        $route_name = "employee.schedule";
                        $user->notify(new ApprovedRequest($user->employee_id,$this->request_leave->id ,$content ,$content_of_content ,$message, $route_name));
                    }
                    session()->flash('success', 'Request approved.');
    
            }else{
                session()->flash('failed', 'Please try again later.');
            }
        }else{
            session()->flash('failed', 'Please try again later.');
        }

        $this->reset('request_leave');
        $this->reset('request_leave_total_days');
        $this->reset('request_leave_modal');


    }

    public function viewLeaveRequest($id)
    {
        $this->request_leave_modal = true;
        $this->request_leave = LeaveRequests::findOrFail($id);
        $from = explode('-', $this->request_leave->from);
        $to = explode('-', $this->request_leave->to);
        if ($from[2] <= $to[2]) {
            $this->request_leave_total_days = abs($from[2] - $to[2]) + 1;
        }else if($from[2] >= $to[2]){
            $total_days = cal_days_in_month(CAL_GREGORIAN, $from[1], $from[0]);
            $f = abs($from[2] - $total_days) + 1;
            $this->request_leave_total_days = $f + $to[2];
        }
    }   

    public function declineRequestOffReason()
    {
        $this->validate([
            'decline_request_off' => 'required'
        ]);
        
        if(Gate::allows('admin')){
            $request = RequestOff::find($this->request_off_decline_id);
            if($request != null){
                $request->reason_to_decline = $this->decline_request_off;
                $request->status = 'declined';
                $request->save();
                $user = User::where('employee_id', $request->employee_id)->first();
                if($user != null){
                    $message = 'Your change rest day request has been declined by the admin with the reason of "' . $this->decline_request_off . '".';
                    $content = 'REQUESTS';
                    $content_of_content = 'OFF';
                    $route_name = "employee.schedule";
                    $user->notify(new DeclinedRequest($user->employee_id,$request->id, $content, $content_of_content, $message, $route_name));
                }

                session()->flash('success', 'Request declined successful.');

            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }

        $this->reset('request_off_decline_modal');
        $this->reset('request_off_decline_id');
        $this->reset('decline_request_off');
    }

    public function declineRequestOff($id)
    {
        $this->request_off_decline_modal = true;
        $this->request_off_modal = false;
        $this->request_off_decline_id = $id;

    }

    public function approveRequestOff($id)
    {
            $request = RequestOff::find($id);
            if($request != null){
            if(Gate::allows('admin')){
                $date = explode('-', $request->date);
                if($date[2] < 10){
                    $str = strval($date[2]);
                    if(strlen($str) == 2){
                        $r_day = intval($str[1]);
                    }elseif(strlen($str) == 1){
                        $r_day = intval($str[0]);
                    }
                }else{
                    $r_day = $date[2];
                }
                
                $r_month = $date[1];
                $r_year = $date[0];
        
                $user_sched =  [];
                if ($r_month == 1) {
                    $user_sched = January::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 2){
                    $user_sched = February::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 3){
                    $user_sched = March::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 4){
                    $user_sched = April::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 5){
                    $user_sched = May::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 6){
                    $user_sched = June::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 7){
                    $user_sched = July::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 8){
                    $user_sched = August::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 9){
                    $user_sched = September::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 10){
                    $user_sched = October::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 11){
                    $user_sched = November::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }else if($r_month == 12){
                    $user_sched = December::where('employee_id', $this->request_off->employee_id)
                                            ->where('year', $r_year)->first();
                }

                    //the rest day that want to change
                    $rd_date = explode('-', $request->rest_day);
                    if($rd_date[2] < 10){
                        $str = strval($rd_date[2]);
                        if(strlen($str) == 2){
                            $change_rd_date = intval($str[1]);
                        }else{
                            $change_rd_date = intval($str[0]);
                        }
                    }else{
                        $change_rd_date = $rd_date[2];
                    }
                    //the schedule of the day that want to change to rest day
                    $r_day_sched = $user_sched->$r_day;
                    if(($user_sched->r_day != 'LEAVE' && $user_sched->r_day != 'On Training') && ($user_sched->$r_day != 'RH' && $user_sched->$r_day != 'SNWH')){
                        $user_sched->$r_day = $user_sched->$change_rd_date;
                        $user_sched->$change_rd_date = $r_day_sched;
                        $request->status = 'approved';
                        $user_sched->save();
                        $request->save();
                        $user = User::where('employee_id', $user_sched->employee_id)->first();
                        if($user != null){
                            $message = "Your change rest day request has been approved by the admin.";
                            $content = 'REQUESTS';
                            $content_of_content = 'OFF';
                            $route_name = "employee.schedule";
                            $user->notify(new ApprovedRequest($user->employee_id,$request->id ,$content ,$content_of_content ,$message, $route_name));
                        }
                        session()->flash('success', 'Request approved.');
                    }else{
                        session()->flash('failed', 'Failed, please try again later.');
                    }
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }

        $this->reset('request_off');
        $this->reset('request_off_modal');

    }

    public function viewRequestOff($id)
    {
        $this->request_off = RequestOff::findOrFail($id);
        $this->request_off_modal = true;
    }

    public function declineScheduleRequests($id)
    {
        $this->schedule_request_decline_id = $id;
        $this->schedule_request_decline_modal = true;
        $this->schedule_request_modal = false;
    }
    

    public function scheduleRequestReason()
    {
        $this->validate([
            'decline' => 'required'
        ]);
        if(Gate::allows('admin')){
            $request = RequestSchedule::find($this->schedule_request_decline_id);
            if($request != null){
                $request->reason_to_decline = $this->decline;
                $request->status = 'declined';
                $request->save();
                $user = User::where('employee_id', $request->employee_id)->first();
                if($user != null){
                    $message = 'You schedule request has been declined by the admin with the reason of "' . $this->decline . '".';
                    $content = 'REQUESTS';
                    $content_of_content = 'SCHEDULE';
                    $route_name = "employee.schedule";
                    $user->notify(new DeclinedRequest($user->employee_id,$request->id, $content, $content_of_content, $message, $route_name));
                }
                session()->flash('success', 'Request declined.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        $this->reset('schedule_request_decline_modal');
        $this->reset('decline');
    }

    public function approveScheduleRequests($id)
    {
        if(Gate::allows('admin')){
            $request = RequestSchedule::find($id);
            if($request != null){
                $cutoff = explode('to', $request->cutoff);
                $arr = explode('-', $cutoff[0]);
                $month = $arr[1];
                $year = $arr[0];
                $this->inputSchedule($month ,$year ,$request->id ,$request->employee_id);
                session()->flash('success', 'Request approved.');

            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');

        }
        $this->schedule_request_modal = false;
    }

    public function inputSchedule($month, $year, $request_schedule_id, $employee_id)
    {
        if ($month == 1) {
            $sched = January::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 2){
            $sched = February::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 3){
            $sched = March::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 4){
            $sched = April::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 5){
            $sched = May::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 6){
            $sched = June::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 7){
            $sched = July::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 8){
            $sched = August::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 9){
            $sched = September::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 10){
            $sched = October::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 11){
            $sched = November::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }else if($month == 12){
            $sched = December::where('employee_id', $employee_id)
                            ->where('year', $year)->first();
        }

        $request = RequestSchedule::findOrFail($request_schedule_id);
        $cutoff = explode('to', $request->cutoff);
        $a = trim($cutoff[0]);
        $b = trim($cutoff[1]);
        $from = explode('-', $a);
        $to = explode('-', $b);
        $yr = $from[0];
        $from_day = $from[2];
        $to_day = $to[2];

     

        if($sched != null){
            for ($i=$from_day; $i <= $to_day; $i++) { 
                if ($i >= 1) {
                 $day = date('D', strtotime("$from[0]-$from[1]-$i")); 
                    if(($sched->$i != 'LEAVE' && $sched->$i != 'On Training') && ($sched->$i != 'RH' && $sched->$i != 'SNWH')){
                        $sched->$i = $request->$day; 
                    }
                }
             }
             $sched->save();

        }

        $request->status = 'approved';
        $user = User::where('employee_id', $sched->employee_id)->first();
        if($user != null){
            $message = "Your schedule request is approved by the admin.";
            $content = 'REQUESTS';
            $content_of_content = 'SCHEDULE';
            $route_name = "employee.schedule";
            $user->notify(new ApprovedRequest($user->employee_id,$request->id ,$content ,$content_of_content ,$message, $route_name));
        }
        $request->save();

    }

    public function viewRequestsSchedule($id)
    {
        $this->schedule_request = RequestSchedule::findOrFail($id);
        $this->schedule_request_modal = true;
    }

    public function schedule()
    {
        $this->requests_content = 'SCHEDULE';
    }
    
    public function leave()
    {
        $this->requests_content = 'LEAVE';
    }

    public function off()
    {
        $this->requests_content = 'OFF';
    }

    public function render()
    {

        $this->coe_requests = CoeRequest::where('status', null)->orderBy('created_at', 'desc')->get();
        $this->pending_leave_requests = LeaveRequests::where('status', 'pending')->orderBy('created_at', 'asc')->take(15)->get();
        $this->pending_off_requests = RequestOff::where('status', 'pending')->orderBy('created_at', 'asc')->take(15)->get();
        $this->pending_schedule_requests = RequestSchedule::where('status', 'pending')->orderBy('created_at', 'asc')->take(15)->get();


        return view('livewire.users.hrofficer.employees-requests'); 
    }
}
