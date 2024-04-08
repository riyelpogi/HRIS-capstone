<?php

namespace App\Livewire\Users\Applicant;

use App\Models\Interviewee;
use App\Models\jobApplicants;
use Livewire\Component;

class ApplicationHistory extends Component
{
    public $applications;
    public $more;

    public $listeners = ['refreshComponent' => '$refresh'];

    public function seeMore($application_id)
    {
        $this->more = $application_id;
    }

    public function hide()
    {
        $this->more = 0;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="w-full flex justify-center items-center ">
            <!-- Loading spinner... -->
          
        </div>
        HTML;
    }

    public function cancelApplication($application_id, $job_id)
    {
        $application = jobApplicants::findOrFail($application_id);
        $application->application_status = 'application canceled';
        $application->save();

        $interviews = Interviewee::where('application_id', $application_id)
                                    ->where('job_id', $job_id)->get();
        foreach ($interviews as $key => $interview) {
            $interview->delete();
        }

        $this->dispatch('refreshComponents');
        
    }

    public function render()
    {
        $this->applications = jobApplicants::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();

        return view('livewire.users.applicant.application-history');
    }
}
