<?php

namespace App\Livewire\Users\Hrofficer\ShowPage;

use App\Mail\ExaminationEmail;
use App\Mail\FailedExaminationEmail;
use App\Mail\FailedFinalInterviewEmail;
use App\Mail\FailedInitialInterviewEmail;
use App\Mail\FinalInterviewEmail;
use App\Mail\FinalInterviewPassedEmail;
use App\Mail\HiredEmail;
use App\Mail\InitialInterviewMail;
use App\Models\April;
use App\Models\August;
use App\Models\December;
use App\Models\EmployeeInformation;
use App\Models\February;
use App\Models\Interviewee;
use App\Models\January;
use App\Models\jobApplicants;
use App\Models\Jobs;
use App\Models\July;
use App\Models\June;
use App\Models\LeaveCredit;
use App\Models\March;
use App\Models\November;
use App\Models\October;
use App\Models\September;
use App\Models\User;
use App\Notifications\applicantNotifications;
use App\Notifications\FailedExamination;
use App\Notifications\failedInterview;
use App\Notifications\HiredNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ApplicantTrackingSystem extends Component
{
    public $ats_content = 'ats_jobs';
    public $jobs;

    #[Rule('required')]
    public $job_title;
    #[Rule('max:500')]
    public $job_description;
    #[Rule('max:500')]
    public $job_responsibilities;
    #[Rule('required')]
    public $job_applicants_limit;
    #[Rule('required')]
    public $hiring_date;
    #[Rule('required')]
    public $hiring_closing_date;
    
    public $job_skills_required = [];
    public $job_qualification;
    public $job_qualifications;
    public $job_qualifications_array = [];
    public $skill; 
    public $skills;
    public $show_job;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public $setInitialInterviewModal = false;
    public $user_id;
    public $job_id; 
    public $applicant_id;

    public $a;
    public $time;
    public $date;

    public $interviewees = [];
    public $finalInterviewModal = false;
    public $initial_interview;

    public $result;
    public $MakefinalInterviewResultModal = false;
    public $MakefinalInterviewResultApplicationId;
    public $finalInterviewresultJobtitle;
    public $finalInterviewresultApplicantName;
    
    public $for_job_offer_applicants;

    public $hire_user;
    public $showHireModal = false;


    #[Rule('required')]
    public $department;
    #[Rule('required')]
    public $position;
    public $hire_user_id;
    public $hire_job_id;
    public $hire_shorlisted_id;
    #[Rule('required')]
    public $deployment_date;
    public $examination_id;
    public $showExamination = false;
    public $exam_date;
    public $exam_time;
    public $exam_a;
    public $showWordInterviewModal = false;
    #[Rule('required')]
    public $interview_from_date;
    #[Rule('required')]
    public $interview_to_date;
    public $job_department;

    public function pushQualification()
    {
        if($this->job_qualification != null){
            array_push($this->job_qualifications_array, $this->job_qualification);
            $this->job_qualifications .= $this->job_qualification . '-';
            $this->reset('job_qualification');
        }
    }

    public function wordInterviewModal()
    {
        $this->showWordInterviewModal = true;
    }


    public function downloadInterviews()
    {
        $this->validate([
            'interview_from_date' => 'required',
            'interview_to_date' => 'required'
        ]);
        $from = explode('-', $this->interview_from_date);
        $from_yr = $from[0];
        $from_month = $from[1];
        $from_day = $from[2];
        $to = explode('-', $this->interview_to_date);
        $to_yr = $to[0];
        $to_month = $to[1];
        $to_day = $to[2];

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $font = new \PhpOffice\PhpWord\Style\Font();
        $font->setBold(true);
        $header = $section->addText('HUMAN RESOURCES INFORMATION SYSTEM INTERVIEWS');
        $header->setFontStyle($font);
        if($from_yr == $to_yr){
            if($from_month <= $to_month){
                for ($i=$from_month; $i <= $to_month; $i++) { 
                    $total_days = cal_days_in_month(CAL_GREGORIAN, $i, $from_yr);
                    $f_day = $from_month == $i ? $from_day : 1;
                    $t_day = $to_month == $i ? $to_day : $total_days;
                    for ($a=$f_day; $a <= $t_day; $a++) { 
                        $interviews = Interviewee::where('date',"$from_yr-$i-$a")
                                                    ->where('status', null)->get();
                        if(count($interviews) > 0){
                            $fontStyle = $section->addText("INTERVIEW FOR $from_yr-$i-$a");
                            $fontStyle->setFontStyle($font);
                            foreach($interviews as $key => $interview){ 
                                $type = strtoupper($interview->interview_type);
                                $section->addText("                ".$interview->user->name . ' - ' . $type . " " .$interview->time ." (" . $interview->job->job_title .")");
                            }
                        }
                    }
                }
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please set the date to same year only.');
        }

        $objWord = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWord->save('Interviews-for-'. $this->interview_from_date . ' to '. $this->interview_to_date .'.docx');

        $f = $this->interview_from_date;
        $t = $this->interview_to_date;
        $this->reset('showWordInterviewModal');
        $this->reset('interview_to_date');
        $this->reset('interview_from_date');

        return response()->download(public_path('Interviews-for-'. $f . ' to '. $t .'.docx'));

    }

    public function setExamination()
    {
        $interview = Interviewee::find($this->examination_id);
        if($interview){
            $interview->status = 'passed';
            $application = jobApplicants::find($interview->application_id);
            if($application){
                $application->application_status = 'Initial Interview Passed';
                $application->save();
                $interview->save();
            }

            $job = Jobs::where('job_id', $interview->job_id)->first();
            $user = User::find($interview->user_id);
            $exam = Interviewee::create([
                'user_id' => $interview->user_id,
                'job_id' => $interview->job_id,
                'date' => $this->exam_date,
                'time' => $this->exam_time . $this->exam_a,
                'interview_type' => 'examination',
                'application_id' => $interview->application_id
            ]);
            $user->notify(new applicantNotifications($user->id, $job->job_title, $exam->date, $exam->time, 'Examination'));
                Mail::to($user)->send(new ExaminationEmail($user->name, $job->job_title, $this->exam_date, $this->exam_time . $this->exam_a));
                session()->flash('success', 'Examination schedule set.');
        }
        $this->reset('exam_date');
        $this->reset('exam_time');
        $this->reset('exam_a');
        $this->reset('showExamination');
        $this->reset('examination_id');
    }

    public function showExaminationModal($id)
    {
        $this->examination_id = $id;
        $this->showExamination = true;

    }

    public function hired()
    {
        $this->validate([
            'department' => 'required',
            'position' => 'required',
            'deployment_date' => 'required'
        ]);

       if(Gate::allows('admin')){
                $user = User::find($this->hire_user_id);
                $job = Jobs::where('job_id', $this->hire_job_id)->first();
                $hiring_limit = explode('/', $job->hiring_limit);
                    if(intval($hiring_limit[1]) <= intval($hiring_limit[0])){
                        session()->flash('failed', 'Failed Hiring limit exceeded');
                        $this->reset();
                    }else{
                        if($user != null){
                            $user->employee_id = 'EID'.$user->id;
                            $user->department = $this->department;
                            $user->position = $this->position;
                            $user->role = 1;
                            $user->status = 'active';
                            $user->save();
                            
                            $hired_number = intval($hiring_limit[0]) + 1;
                            $job->hiring_limit = strval($hired_number) ."/".strval($hiring_limit[1]);
                            $job->save();
                            $interview = Interviewee::find($this->hire_shorlisted_id);
                            if($interview != null){
                                $interview->status = 'hired';
                                $interview->save();
                                
                            }   
        
        
                            $info = EmployeeInformation::where('employee_id', $user->id)->first();
                            if($info != null){
                                $info->deployment_date = $this->deployment_date;
                                $info->employee_id = $user->employee_id;
                                $info->date_hired = date('Y-m-d', time());
                                $info->save();
                            }
        
                            $leaveCredit = LeaveCredit::create([
                                'employee_id' => $user->employee_id,
                                'leave_credit' => 6
                            ]);
        
                            foreach($user->notifications as $key => $notification){
                                $notification->delete();
                            }
        
                            $user->notify(new HiredNotification($user->name, $this->position, $this->department, date('Y-m-d', time())));
                            $month = date('n', time()); 
                            $year = date('Y', time()); 
                            if ($month <= 1) {
                                January::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 2){
                                February::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 3){
                                March::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 4){
                                April::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 5){
                                March::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 6){
                                June::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 7){
                                July::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 8){
                                August::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 9){
                                September::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 10){
                                October::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 11){
                                November::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }else if($month <= 12){
                                December::create([
                                    'employee_id' => $user->employee_id,
                                    'year' => $year
                                ]);
                            }
                            Mail::to($user)->send(new HiredEmail($user->name, $this->position, $this->department));
                            session()->flash('success', 'Hired successful.');
                    }

                
                }
           

       }else{
            session()->flash('failed', 'Failed, please try again later.');
       }

       $this->reset('hire_user_id');
       $this->reset('position');
       $this->reset('hire_job_id');
       $this->reset('hire_shorlisted_id');
       $this->reset('showHireModal');
    }
    public function hire($id, $job_title, $job_id, $shorlisted_id)
    {
        $this->hire_user = User::find($id);
        $job = Jobs::where('job_id', $job_id)->first();
        $this->department = $job->job_department . ' Department';
        $this->hire_user_id = $id;
        $this->position = $job_title;
        $this->hire_job_id = $job_id;
        $this->hire_shorlisted_id = $shorlisted_id;
        $this->showHireModal = true;
    }


    public function openJob($id)
    {
        $job = Jobs::find($id);
        if(Gate::allows('admin')){
            if($job != null){
                $job->status = 'On Going';
                $job->save();
                session()->flash('success', 'Update successful.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }

        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }

    public function closeJob($id)
    {
        $job = Jobs::find($id);
        if(Gate::allows('admin')){
            if($job != null){
                $job->status = 'Closed';
                $job->save();
                session()->flash('success', 'Update successful.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }

        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }

    }

    public function finalInterviewResult()
    {
        $application = Interviewee::find($this->MakefinalInterviewResultApplicationId);
        if(Gate::allows('admin')){
            if ($application != null) {
                if($application->interview_type == 'final'){
                  if($this->result == 'pass'){
                    $application->status = 'passed';
                    $application_record = jobApplicants::find($application->application_id);
                    if($application_record != null){
                        $application_record->application_status = 'final interview passed';
                        $application_record->save();
                        $application->save();
                        $user = User::find($application->user_id);
                        $job = Jobs::where('job_id', $application->job_id)->first();
                        if($user != null){
                            $user->notify(new applicantNotifications($user->id, $job->job_title, 
                            $application->date,$application->time, 'Final Interview Passed'));
                            Mail::to($user)->send(new FinalInterviewPassedEmail($user->name, $job->job_title, $application->date, $application->time));
                        }
                    }

                  }else if($this->result == 'fail'){
                    $application->status = 'failed';
                    $application_record = jobApplicants::find($application->application_id);
                    if($application_record != null){
                        $application_record->application_status = 'final interview failed';
                        $user = User::find($application->user_id);
                        $job = Jobs::where('job_id', $application->job_id)->first();
                        if($user != null){
                            $user->notify(new failedInterview($user->id, $job->job_title, 'Final Interview'));
                            Mail::to($user)->send(new FailedFinalInterviewEmail($user->name, $job->job_title, $application->date, $application->time));
                            $application->save();
                            $application_record->save();
                        }
                    }
    
                  }

                    session()->flash('success', 'Update successful.');
                }else{
                    session()->flash('failed', 'Failed, please try again later.');
                }
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }

        $this->reset('finalInterviewresultApplicantName');
        $this->reset('finalInterviewresultJobtitle');
        $this->reset('MakefinalInterviewResultApplicationId');
        $this->reset('MakefinalInterviewResultModal');

    }

    public function MakefinalInterviewResult($application_id)
    {
        $result = Interviewee::findOrFail($application_id);
        $this->finalInterviewresultApplicantName = $result->user->name;
        $this->finalInterviewresultJobtitle = $result->job->job_title;
        $this->MakefinalInterviewResultApplicationId = $application_id;
        $this->MakefinalInterviewResultModal = true;

    }

    public function finalInterview()
    {
        if(Gate::allows('admin')){
            $initial_interview = Interviewee::findOrFail($this->initial_interview);
            $initial_interview->status = 'passed';

            $application_record = jobApplicants::findOrFail($initial_interview->application_id);
            $application_record->application_status = 'initial interview passed';
            $application_record->save();
            $initial_interview->save();

            $job = Jobs::where('job_id', $initial_interview->job_id)->first();
            $user = User::find($initial_interview->user_id);
            if($user != null){
                $finterview = Interviewee::create([
                    'user_id' => $initial_interview->user_id,
                    'job_id' => $initial_interview->job_id,
                    'date' => $this->date,
                    'time' => $this->time . $this->a,
                    'interview_type' => 'final',
                    'application_id' => $initial_interview->application_id
                ]);

                $user->notify(new applicantNotifications($user->id, $job->job_title, $finterview->date, $finterview->time, 'Final Interview'));
                Mail::to($user)->send(new FinalInterviewEmail($user->name, $job->job_title, $this->date, $this->time . $this->a));
                session()->flash('success', 'Final interview set successful.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }

        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        $this->reset();
    }

    public function showFinalInterviewModal($id)
    {
        $this->initial_interview = $id;
        $this->finalInterviewModal = true;
    }

    public function fail_examination($id)
    {
        $initial = Interviewee::find($id);
        if($initial != null){
            if(Gate::allows('admin')){
                 $initial->status = 'failed';
                 $application_record = jobApplicants::find($initial->application_id);
                 if($application_record != null){
                     $application_record->application_status = 'Examination Failed';
                     $application_record->save();
                     $initial->save();
                     $job = Jobs::where('job_id', $initial->job_id)->first();
                     $user = User::find($initial->user_id);
                     if($user != null){
                         $user->notify(new FailedExamination($user->id,$job->job_title,'Failed Examination'));
                         Mail::to($user)->send(new FailedExaminationEmail($user->name, $job->job_title, $initial->date, $initial->time));
                     }
                     $this->dispatch('refreshComponent');
                     session()->flash('success', 'Successful.');
                 }else{
                 session()->flash('failed', 'Failed, please try again later.');
                 }
            }else{
             session()->flash('failed', 'Failed, please try again later.');
            }
         }else{
             session()->flash('failed', 'Failed, please try again later.');
         }
    }

    public function fail_initial_interview($id)
    {
        $initial = Interviewee::find($id);
        if($initial != null){
           if(Gate::allows('admin')){
                $initial->status = 'failed';
                $application_record = jobApplicants::find($initial->application_id);
                if($application_record != null){
                    $application_record->application_status = 'initial interview failed';
                    $application_record->save();
                    $initial->save();
                    $job = Jobs::where('job_id', $initial->job_id)->first();
                    $user = User::find($initial->user_id);
                    if($user != null){
                        $user->notify(new failedInterview($user->id,$job->job_title,'Initial Interview'));
                        Mail::to($user)->send(new FailedInitialInterviewEmail($user->name, $job->job_title, $initial->date, $initial->time));
                    }
                    $this->dispatch('refreshComponent');
                    session()->flash('success', 'Successful.');
                }else{
                session()->flash('failed', 'Failed, please try again later.');
                }
           }else{
            session()->flash('failed', 'Failed, please try again later.');
           }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }

    public function setInterview($user_id, $job_id, $applicant_id)
    {
        $this->job_id = $job_id;
        $this->user_id = $user_id;
        $this->applicant_id = $applicant_id;
        $this->setInitialInterviewModal = true;
    }

    public function initialInterview()
    {
        $this->validate([
            'a' => 'required',
            'time' => 'required',
            'date' => 'required'
        ]);

        $job = Jobs::where('job_id', $this->job_id)->first();
        $user = User::find($this->user_id);
        if(Gate::allows('admin')){
            if($user->role == 0 && $user != null){
                $interview = Interviewee::create([
                    'user_id' => $this->user_id,
                    'job_id' => $this->job_id,
                    'date' => $this->date,
                    'time' => $this->time . $this->a,
                    'interview_type' => 'initial',
                    'application_id' => $this->applicant_id
                ]);
                $user->notify(new applicantNotifications($user->id,$job->job_title, $this->date, $interview->time, 'Initial Interview'));
                $applicant = jobApplicants::findOrFail($this->applicant_id);
                $applicant->application_status = 'initial';
                $applicant->scheduled = 'done';
                $applicant->save();
                Mail::to($user)->send(new InitialInterviewMail($user->name, $job->job_title, $this->date, $this->time . $this->a));
                session()->flash('success', 'Initial interview set successful.');
            }else{
            session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        $this->reset('setInitialInterviewModal');
        $this->reset('time');
        $this->reset('date');
        $this->reset('a');
        $this->dispatch('refreshComponent');
    }

    public function showJob($job_id)
    {
        $this->show_job = Jobs::where('job_id', $job_id)->first();
        $this->dispatch('refreshComponent');
    }

    public function postAJob()
    {
        $this->validate([
            'job_title' => 'required',
            'job_applicants_limit' => 'required',
            'job_department' => 'required',
            'hiring_date' => 'required',
            'hiring_closing_date' => 'required',
        ]);
        if(Gate::allows('admin')){
            $job = Jobs::create([
                'admin_employee_id' => auth()->user()->employee_id,
                'job_title' => $this->job_title,
                'job_description' => $this->job_description,
                'job_responsibilities' => $this->job_responsibilities,
                'job_skills_required' => $this->skills,
                'job_qualifications' => $this->job_qualifications,
                'job_department' => $this->job_department,
                'hiring_limit' => "0/".$this->job_applicants_limit,
                'hiring_date' => $this->hiring_date,
                'hiring_closing_date' => $this->hiring_closing_date,
            ]);
                $job->job_id = 'JID'.$job->id;
                $job->save();
                session()->flash('success', 'Job posted successful.');
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
        $this->reset();

    }

    public function pushSkill()
    {
        if($this->skill != null){
            array_push($this->job_skills_required, $this->skill);
            $this->skills .= $this->skill. "-";
            $this->skill = "";
        }
    }

    public function atsjobs()
    {
        $this->ats_content = 'ats_jobs';
        $this->dispatch('refreshComponent');
    }
    
    public function atsshortlisted()
    {
        $this->ats_content = 'ats_shortlisted';
    }

    public function atsinterviewee()
    {
        $this->ats_content = 'ats_interviewee';
        $arr = [];
        $this->interviewees = Interviewee::orderBy('created_at', 'DESC')->get();
    }

    public function atspostajob()
    {
        $this->ats_content = 'ats_postajob';
        $this->dispatch('refreshComponent');
    }
    

    public function render()
    {
        $this->jobs = Jobs::orderBy('created_at', 'desc')->take(10)->get();
        return view('livewire.users.hrofficer.show-page.applicant-tracking-system');
    }
}
