<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\Benefits as ModelsBenefits;
use App\Models\BenefitsApplicant;
use App\Models\User;
use App\Notifications\BenefitApplicationApprovedNotification;
use App\Notifications\benefitUpdateNotification;
use App\Notifications\NewBenefitNotification;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Benefits extends Component
{

    #[Rule("required")]
    public $benefit_name;
    #[Rule("required|max:500")]
    public $benefit_description;
    public $benefit_requirement;
    public $requirements = [];
    public $addBenefitModal = false;


    public $benefits;
    public $benefitExtend;
    public $content = '';

    public $request;
    public $requestActionModal = false;
    
    #[Rule('required|max:1000')]
    public $notice;
    #[Rule('required')]
    public $status;
    public $request_name;
    public $request_position;
    public $request_department;
    public $beneficiaries = [];
    public $showBeneficiaries = false;
    public $bnft_name;
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
    public function openApplication($id)
    {
        $benefit = ModelsBenefits::find($id);
        if(Gate::allows('admin')){
            if($benefit != null){
                $benefit->status = 'open';
                $benefit->save();
                session()->flash('success', 'Success.');
            }else{
            session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }

    public function closeApplication($id)
    {
        $benefit = ModelsBenefits::find($id);
        if(Gate::allows('admin')){
            if($benefit != null){
                $benefit->status = 'closed';
                $benefit->save();
                session()->flash('success', 'Success.');
            }else{
            session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        
    }

    public function showBeneficiariesModal($id)
    {
        $this->beneficiaries = BenefitsApplicant::where('benefit_id', $id)
                                                ->where('status', 'approved')->get();
        $benefit = \App\Models\Benefits::find($id);
        $this->bnft_name = $benefit->benefit_name;
        $this->showBeneficiaries = true;

    }

    public function submitAction()
    {
        $this->validate([
            'notice' => 'required|max:1000',
            'status' => 'required'
        ]);


        if(Gate::allows('admin')){
                $request = BenefitsApplicant::find($this->request->id);
                if($request != null){
                        $request->notice = $this->notice;
                        $request->status = $this->status;
                        $route_name = 'employee.benefits';
                        $content = 'REQUEST';
                        $user = User::where('employee_id', $request->employee_id)->first();
                        if($this->status != 'approved'){
                            $user->notify(new benefitUpdateNotification($user->employee_id, $request->benefit->id, $request->benefit->benefit_name, $route_name, $content));
                        }else{
                            $user->notify(new BenefitApplicationApprovedNotification($user->employee_id, $request->benefit->id, $request->benefit->benefit_name, $route_name, $content));
                            $request->date_approved = date('Y-m-d', time());
                        }
                        
                        $request->save();
                    session()->flash('success', 'Submit successful.');
                }else{
                    session()->flash('failed', 'Failed, please try again later.');
                }
        }else{
                 session()->flash('failed', 'Failed, please try again later.');
        }

        $this->reset('notice');
        $this->reset('status');
        $this->reset('request');
        $this->reset('requestActionModal');
    }
    
    public function showRequestActionModal($id)
    {
        $this->request = BenefitsApplicant::find($id);
        $this->request_name = $this->request->user->name;
        $this->request_position = $this->request->user->position;
        $this->request_department = $this->request->user->department;
        $this->requestActionModal = true;
    }

    public function show($id)
    {
        $this->benefitExtend = $id;
    }
    public function hide($id)
    {
        $this->benefitExtend = '';
    }

    
    public function addBenefit()
    {
        $this->validate([
            'benefit_name' => 'required',
            'benefit_description' => 'required|max:500',
        ]);
        
        if(Gate::allows('admin')){
                $str = implode('-', $this->requirements);

                $benefit = ModelsBenefits::create([
                    'benefit_name' => $this->benefit_name,
                    'benefit_description' => $this->benefit_description,
                    'benefit_requirements' => $str,
                ]);

                if($benefit){
                    $route_name = 'employee.benefits';
                    $content = 'BENEFITS';
                    $users = User::where('role', 1)->get();
                    foreach ($users as $key => $user) {
                        $user->notify(new NewBenefitNotification($benefit->id, $route_name, $content));
                    }
                }else{
                    session()->flash('failed', 'Failed, please try again later.');
                }
        }else{
            session()->flash('failed', 'Failed, please try again later.');

        }

        $this->reset('benefit_name');
        $this->reset('benefit_description');
        $this->reset('benefit_requirement');
        $this->reset('requirements');
        $this->reset('addBenefitModal');

    }

    public function showAddBenefitsModal()
    {
        $this->addBenefitModal = true;
    }

    public function addrequirement()
    {
        if($this->benefit_requirement != null){
            array_push($this->requirements, $this->benefit_requirement . ".");
            $this->benefit_requirement = '';
        }
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

        $this->benefits = ModelsBenefits::where('status', '!=', 'done')->get();
        return view('livewire.users.hrofficer.benefits');
    }
}
