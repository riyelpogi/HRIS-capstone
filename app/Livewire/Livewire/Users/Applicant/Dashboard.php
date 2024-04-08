<?php

namespace App\Livewire\Users\Applicant;

use App\Models\jobApplicants;
use App\Models\Jobs;
use App\Models\User;
use App\Notifications\JobApplicantsNotification;
use Livewire\Component;

class Dashboard extends Component
{
    public $jobs;
    public $more;
    public $job_content;
    public $search;
    public function showOthersJobs()
    {
        $this->job_content = 'OTHERS';
    }

    public function showAllJobs()
    {
        $this->job_content = 'ALL';
    }

    public function showPurchasingJobs()
    {
        $this->job_content = 'PURCHASING';
    }
    public function showFinanceJobs()
    {
        $this->job_content = 'FINANCE';
    }
    public function showMarketingJobs()
    {
        $this->job_content = 'MARKETING';
    }
    public function showHrJobs()
    {
        $this->job_content = 'HUMAN RESOURCES';
    }
    public function showAccJobs()
    {
        $this->job_content = 'ACCOUNTING';
    }
    public function showItJobs()
    {
        $this->job_content = 'INFORMATION TECHNOLOGY';
    }
    public function expand($job_id)
    {
        if ($this->more == $job_id) {
            $this->more = null;
        }else{
            $this->more = $job_id;
        }

    }

    public function loginFirst()
    {
        session()->flash('failed', 'Please login or create an account before applying to a job.');
    }

    public function apply($job_id, $user_id)
    {
        if(auth()->user()->employee_information != null){
            if(auth()->user()->employee_information->resume != null){
                $job_data = Jobs::where('job_id',$job_id)->first();
                $hiring_limit = explode('/', $job_data->hiring_limit);
                if (intval($hiring_limit[1]) >= intval($hiring_limit[0])) {
                    $job = jobApplicants::create([
                        'job_id' => $job_id,
                        'user_id' => auth()->user()->id
                    ]);
                    if($job_data->job_applicants != null){
                        $job_data->job_applicants .= auth()->user()->id .'-';
                    }else{
                        $job_data->job_applicants = auth()->user()->id . '-';
                    }
                    $job_data->save();
                    $admin = User::where('employee_id', $job_data->admin_employee_id)->first();
                    $admin->notify(new JobApplicantsNotification($job_data->job_title, $job_data->job_id));
                session()->flash('success', 'Applied Successful.');
                }else{
                session()->flash('failed', 'Applicants limit reached.');

                }
               

            }else{
            session()->flash('failed', 'Please upload a resume first before applying to a job.');

            }
        }else{
            session()->flash('failed', 'Please configure your user information.');
        }
    }

    public function render()
    {
        if($this->job_content == null){
            $this->job_content = 'ALL';
            $this->jobs = Jobs::where('status', 'On Going')->orderBy('created_at', 'desc')->get();

        }elseif ($this->job_content == "INFORMATION TECHNOLOGY") {
            $this->jobs = Jobs::where('status', 'On Going')->where('job_department', 'INFORMATION TECHNOLOGY')->orderBy('created_at', 'desc')->get();
        }elseif ($this->job_content == "ACCOUNTING") {
            $this->jobs = Jobs::where('status', 'On Going')->where('job_department', 'ACCOUNTING')->orderBy('created_at', 'desc')->get();

        }elseif ($this->job_content == "HUMAN RESOURCES") {
            $this->jobs = Jobs::where('status', 'On Going')->where('job_department', 'HUMAN RESOURCES')->orderBy('created_at', 'desc')->get();

        }elseif ($this->job_content == "MARKETING") {
            $this->jobs = Jobs::where('status', 'On Going')->where('job_department', 'MARKETING')->orderBy('created_at', 'desc')->get();

        }elseif ($this->job_content == "FINANCE") {
            $this->jobs = Jobs::where('status', 'On Going')->where('job_department', 'FINANCE')->orderBy('created_at', 'desc')->get();

        }elseif ($this->job_content == "PURCHASING") {
            $this->jobs = Jobs::where('status', 'On Going')->where('job_department', 'PURCHASING')->orderBy('created_at', 'desc')->get();

        }elseif ($this->job_content == "OTHERS") {
            $this->jobs = Jobs::where('status', 'On Going')->where('job_department', 'OTHERS')->orderBy('created_at', 'desc')->get();
        }elseif($this->job_content == 'ALL'){
            $this->jobs = Jobs::where('status', 'On Going')->orderBy('created_at', 'desc')->get();
        }

        if($this->search != null){
            $this->jobs = Jobs::where('job_title', 'LIKE', '%'.$this->search.'%')->where('status', 'On Going')->orderBy('created_at', 'desc')->get();

        }
        return view('livewire.users.applicant.dashboard');
    }
}
