<?php

namespace App\Livewire\Users\Employee;

use App\Models\Benefits as ModelsBenefits;
use App\Models\BenefitsApplicant;
use App\Models\DtrTicket;
use App\Models\User;
use App\Notifications\BenefitApplicantNotification;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Benefits extends Component
{

    use WithFileUploads;
    public $benefits;
    public $benefitExtend;
    public $content = '';
    public $requests;


    public $sick_leave;
    public $sick_leave_modal = false;

    #[Rule('required')]
    public $from_date;
    #[Rule('required')]
    public $to_date;
    #[Rule('required|mimes:jpeg,pdf,jpg,png,bng')]
    public $med_cert;


    public $showImage = false;
    public $image;

    public $maternity_id;
    public $maternityModal = false;


    #[Rule('required')]
    public $pregnant;
    #[Rule('required|mimes:jpeg,pdf,jpg,png,bng')]
    public $proof;
    public $proofModal = false;
    public $proofImage;
    public $parameter_id;

    public function mount($id, $content)
    {
        if($id != null){
            $this->parameter_id = $id;
        }

        if($content != null){
            $this->content = $content;
        }
    }

    public function cancelRequest($id)
    {
        $request = BenefitsApplicant::find($id);
        if($request != null){
            if(Gate::allows('cancel-benefit-application', $request)){
                $request->status = 'canceled';
                $request->save();
                session()->flash('success', 'Canceled');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }

    public function applyBenefit($id)
    {
        if(Gate::allows('employee')){
            $benefit = \App\Models\Benefits::find($id);
            if($benefit != null){
                $applicant = BenefitsApplicant::create([
                    'employee_id' => auth()->user()->employee_id,
                    'benefit_id' => $id,
                ]);
                
                $route_name = 'admin.benefits';
                $content = 'REQUEST';
                $admins = User::where('role', 2)->get();
                foreach($admins as $key => $admin){
                    $admin->notify(new BenefitApplicantNotification(auth()->user()->employee_id, $benefit->id, $benefit->benefit_name, $route_name, $content));
                }
                session()->flash('success', 'Applied successful.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }

    }

    public function show($id)
    {
        $this->benefitExtend = $id;
    }
    public function hide($id)
    {
        $this->benefitExtend = '';
    }

    
    public function showBenefits()
    {
        $this->content = 'BENEFITS';
    }

    public function showRequest()
    {
        $this->content = 'REQUEST';
    }

    public function render()
    {

        if($this->content == null){
            $this->content = 'BENEFITS';
        }

        $this->benefits = ModelsBenefits::where('status', 'open')->get();
        $this->requests = BenefitsApplicant::where('employee_id', auth()->user()->employee_id)->orderBy('created_at', 'desc')->get();

        return view('livewire.users.employee.benefits');
    }
}
