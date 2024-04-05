<?php

namespace App\Livewire\Users\Hrofficer\ShowUsers;

use App\Mail\HiredEmail;
use App\Models\April;
use App\Models\August;
use App\Models\December;
use App\Models\EmployeeInformation;
use App\Models\February;
use App\Models\January;
use App\Models\July;
use App\Models\June;
use App\Models\Leave;
use App\Models\LeaveCredit;
use App\Models\March;
use App\Models\May;
use App\Models\November;
use App\Models\October;
use App\Models\September;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ShowApplicants extends Component
{
    public $content;
    public $employees;
    public $search;
    
    public $searchapplicants;
    public $applicants;

    public $hireShowModal = false;
    public $applicant;

    protected $listeners = ['refreshComponent' => '$refresh'];

    #[Rule('required')]
    public $department;

    #[Rule('required')]
    public $position;

    public $applicant_name;
    public $applicant_id;
    #[Rule('required')]
    #[Rule('required')]
    public $deployment_date;

    public function hireModal($id)
    {
        $this->hireShowModal = true;
        $this->applicant = User::findOrFail($id);
        $this->applicant_id = $id;
        $this->applicant_name = $this->applicant->name;

    }

    public function hired()
    {
        $this->validate([
            'department' => 'required',
            'position' => 'required',
            'deployment_date' => 'required'
        ]);
        if(Gate::allows('admin')){
            $applicant = User::find($this->applicant_id);
            if($applicant != null){
                $applicant->employee_id = 'EID'.$applicant->id;
                $applicant->department = $this->department;
                $applicant->position = $this->position;
                $applicant->role = 1;
                $applicant->status = 'active';
        
                $info = EmployeeInformation::where('employee_id', $this->applicant_id)->first();
                if($info != null){
                    $info->employee_id = 'EID'.$applicant->id;
                    $info->date_hired = date('Y-m-d', time());
                    $info->deployment_date = $this->deployment_date;
                    $info->save();
                    
                }else{
                    $info = EmployeeInformation::create([
                        'employee_id' => 'EID'.$applicant->id,
                        'date_hired' => date('Y-m-d', time()),
                    ]);
                }
                $applicant->save();
                $applicant = User::findOrFail($this->applicant_id);
                    $month = date('m', time());
            
                    $leave_credit = LeaveCredit::create([
                        'employee_id' => $info->employee_id,
                        'leave_credit' => 6
                    ]);
                   Mail::to($applicant)->send(new HiredEmail($applicant->name, $this->position, $this->department)); 
                session()->flash('success', 'Hired successful.');
            }else{
            session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }

        

        $this->reset();
        $this->dispatch('refreshComponent');
    }

    public function render()
    {
        if($this->searchapplicants != null){
            $this->applicants = User::where('name', $this->searchapplicants)
                                      ->where('role', 0)
                                      ->get();
          }else{
            $this->applicants = User::where('role', 0)->take(20)->get();
          }
        return view('livewire.users.hrofficer.show-users.show-applicants');
    }
}
