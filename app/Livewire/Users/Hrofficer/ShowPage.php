<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\EmployeeInformation;
use App\Models\Leave;
use App\Models\LeaveCredit;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ShowPage extends Component
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

    public function hireModal($id)
    {
        $this->hireShowModal = true;
        $this->applicant = User::findOrFail($id);
        $this->applicant_id = $id;
        $this->applicant_name = $this->applicant->name;

    }

    public function hired()
    {
        $this->validate();
        
        $applicant = User::findOrFail($this->applicant_id);
        $applicant->employee_id = 'EID'.$applicant->id;
        $applicant->department = $this->department;
        $applicant->position = $this->position;
        $applicant->role = 1;

        $info = EmployeeInformation::where('employee_id', $this->applicant_id)->first();
        $info->employee_id = 'EID'.$applicant->id;
        $info->save();
        $applicant->save();

        $applicant = User::findOrFail($this->applicant_id);
        $month = date('m', time());

        $employee_leave = LeaveCredit::create([
              'employee_id' => $applicant->employee_id,         
              'total' => '0'
        ]);

        $this->reset();
        $this->dispatch('refreshComponent');
    }

    public function render()
    {       
      if($this->search != null){
        $this->employees = User::where('name',$this->search)
                                ->where('role', 1)
                                ->get();
      }else{
        $this->employees = User::where('role', 1)->get();
      }

      if($this->searchapplicants != null){
        $this->applicants = User::where('name', $this->searchapplicants)
                                  ->where('role', 0)
                                  ->get();
      }else{
        $this->applicants = User::where('role', 0)->get();
      }


        return view('livewire.users.hrofficer.show-page', );
    }
}
