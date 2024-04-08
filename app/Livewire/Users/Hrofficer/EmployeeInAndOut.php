<?php

namespace App\Livewire\Users\Hrofficer;

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
use App\Notifications\ApprovedRequest;
use App\Notifications\DeclinedRequest;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeInAndOut extends Component
{
    use WithFileUploads;

    public $content = '';

    public $uploadModal = false;
    #[Rule('required|mimes:xlsx')]
    public $excel;
    //public $histories;
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $tickets;
    public $showProofModal = false;
    public $file_name;
    
    public $showTicketModal = false;
    public $ticket;

    public $showDeclineTicketModal = false;
    public $declineTicketId;

    #[Rule('required')]
    public $reason_to_decline;

    public function mount($content)
    {
        if($content != null){
            $this->content = $content;
        }
    }

    public function submitDeclineTicket()
    {
        $ticket = DtrTicket::find($this->declineTicketId);
        if($ticket != null){
            if(Gate::allows('request-update')){
                $ticket->status = 'declined';
                $ticket->reason_to_decline = $this->reason_to_decline;
                $ticket->save();
                $message = 'Your ticket has been declined by the admin with the reason of "' . $this->reason_to_decline . '".'; 
                $content = "MYTICKETS";
                $route_name = "employee.daily.time.record";
                $ticket->user->notify(new DeclinedRequest($ticket->employee_id,$ticket->id,$content,'', $message, $route_name));
                session()->flash('success', 'You successfully review the ticket.');

            }else{
                session()->flash('failed', 'You do not have permission for this.');
            }
        }

        $this->reset('declineTicketId');
        $this->reset('showDeclineTicketModal');
    }
    public function declineTicket($id)
    {
        $this->declineTicketId = $id;
        $this->showDeclineTicketModal = true;
        $this->showTicketModal = false;
        // $ticket = DtrTicket::find($id);
        // if($ticket != null){
        //     $ticket->status = 'declined';
            
        // }
    }
    public function approveTicket($id)
    {
        $ticket = DtrTicket::find($id);
        if(Gate::allows('admin')){
                    if($ticket != null){
                        $date = explode('-', $ticket->date);
                        $inandout = InandOut::where('employee_id', $ticket->employee_id)
                                                ->where('year', $date[0])
                                                ->where('month', $date[1])
                                                ->where('date', $date[2])
                                                ->where('inorout', $ticket->inorout)->first();
                    if($inandout != null){
                        $recorded_time_in = $inandout->time;     
                        $request_time_in = explode(':', $ticket->time);
                        $hr = $request_time_in[0];
                        $merediem = '';
                        if($hr >= 13){
                            $hr -= 12;
                            $merediem = 'pm';
                        }else{
                            $merediem = 'am';
                        }
                        
                        $str_hr = strval($hr);
                        if(strlen($str_hr) > 1){
                            if($hr < 10){
                                $r_hr = $hr[1];
                            }else{
                                $r_hr = $hr;
                            }
                        }else{
                            $r_hr = $hr;
                        }
            
                        
            
                        $inandout->time = $r_hr.':'.$request_time_in[1].$merediem;
                        $ticket->status = 'approved';
                        $ticket->save();
            
                        if($date[1] == 1){
                            $sched = January::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 2){
                            $sched = February::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 3){
                            $sched = March::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 4){
                            $sched = April::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 5){
                            $sched = May::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 6){
                            $sched = June::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 7){
                            $sched = July::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 8){
                            $sched = August::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 9){
                            $sched = September::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 10){
                            $sched = October::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 11){
                            $sched = November::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }else if($date[1] == 12){
                            $sched = December::where('employee_id', $ticket->employee_id)
                                            ->where('year', date('Y', time()))->first();
                        }
                        
                        if($ticket->inorout == 'IN'){
                                $inandout->status = null;
                        }else if($ticket->inorout == 'OUT'){
                                $inandout->status = null;
                        }
                        $inandout->save();
                        $message = "Your ticket has been approved by the admin, please see DTR for more details.";
                        $route_name = "employee.daily.time.record";
                        $content = 'MYTICKETS';
                        $ticket->user->notify(new ApprovedRequest($ticket->employee_id, $ticket->id ,$content, '', $message, $route_name));
                        session()->flash('success', 'Approved successful.');
                      }else{
                            session()->flash('failed', 'Failed, please try again later.');
                      }
                    }else{
                session()->flash('failed', 'Failed, please try again later.');
                    }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
            $this->reset('ticket');
            $this->reset('showTicketModal');
    }

    public function showTicket($id)
    {
        $this->ticket = DtrTicket::find($id);
        $this->showTicketModal = true;
    }
    public function showProof($file_name)
    {
        $this->showProofModal = true;
        $this->file_name = $file_name;
    }

    public function showinandout()
    {
        $this->content = 'INANDOUT';
    }

    public function showTickets()
    {
        $this->content = 'TICKETS';
    }

    public function uploadFileExcel()
    {
        $this->validate([
            'excel' => 'required|mimes:xlsx'
        ]);

        if(Gate::allows('admin')){
            Excel::import(new \App\Imports\EmployeeInandOut, $this->excel);
            session()->flash('success', 'Upload successful.');
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        
        $this->reset('excel');
        $this->reset('uploadModal');
        $this->dispatch('refreshComponent');

    }

    public function uploadFileModal()
    {
        $this->uploadModal = true;
    }
    
    public function render()
    {
        if($this->content == null){
            $this->content = 'INANDOUT';
        }

        $this->tickets = DtrTicket::where('status', 'pending')->orderBy('created_at', 'desc')->take(20)->get();

        $histories = InandOut::orderBy('created_at', 'desc')->take(25)->get();
        return view('livewire.users.hrofficer.employee-in-and-out', ['histories' => $histories]);
    }
}
