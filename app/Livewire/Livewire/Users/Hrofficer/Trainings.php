<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\April;
use App\Models\August;
use App\Models\December;
use App\Models\Ebook;
use App\Models\February;
use App\Models\January;
use App\Models\July;
use App\Models\June;
use App\Models\March;
use App\Models\May;
use App\Models\November;
use App\Models\October;
use App\Models\September;
use App\Models\TrainingApplicant;
use App\Models\TrainingsAvailable;
use App\Models\User;
use App\Models\Video;
use App\Models\Website;
use App\Notifications\TrainingApplicantApprovedNotification;
use App\Notifications\TrainingNotification;
use App\Notifications\TrainingStartNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Trainings extends Component
{
    use WithFileUploads;
    public $training_content = '';
    public $training_availables;
    public $addTrainingModal = false;

    #[Rule('required')]
    public $training_name;
    #[Rule('required')]
    public $department;
    #[Rule('required')]
    public $start_date;
    #[Rule('required')]
    public $to_date;
    #[Rule('required')]
    public $training_description;
    public $ElearningMaterialModal = false;
    public $ElearningMaterialModal_content;

    #[Rule('required')]
    public $ebook_name;
    #[Rule('required|mimes:pdf,e.pub,mobi')]
    public $ebook_file;

    //  #[Rule('required|max:1000000000')]
    public $video_file;
    #[Rule('required')]
    public $video_name;

    #[Rule('required')]
    public $website_name;
    #[Rule('required')]
    public $website_description;
    #[Rule('required')]
    public $website_link;
    public $take_ebook;
    public $take_video;
    public $take_website;
    public $learning_materials_content;
    public $e_books;
    public $e_videos;
    public $e_websites;
    public $previewModal = false;
    public $previewEbook;
    public $search_ebook = '';
    public $search_videos = '';
    public $search_websites = '';
    public $trainingModal = false;
    public $training;

    public $parameter_id;
    public function mount($id, $content)
    {
        if($id != null){    
            $this->parameter_id = $id;
        }

        if($content != null){
            $this->training_content = $content;
        }

   $trainings = TrainingsAvailable::where('status', 'pending')->get();
        foreach ($trainings as $key => $value) {
                $date = explode('-', $value->start_date);
                $t_yr = $date[0];
                $t_month = $date[1];
                $t_day = $date[2];

                $yr = date('Y', time());
                $month = date('m', time());
                $day = date('d', time());

                if($t_yr == $yr){
                    if($t_month == $month){
                        if($t_day == $day){
                            $value->status = 'On Going';
                            $value->save();
                            $route_name = "employee.training";
                            $content = "TRAININGS";
                                foreach($value->approved_applicants  as $key => $participant){
                                    $prtcpnt = User::where('employee_id', $participant->employee_id)->first();
                                    $prtcpnt->notify(new TrainingStartNotification($prtcpnt->employee_id, $value->id, $value->training_name, $content, $route_name));
                                }
                            $admin = User::where('role', 2)->first();    
                            $admin->notify(new TrainingStartNotification($admin->employee_id, $value->id, $value->training_name, $content, $route_name));
                        }
                    }
                }


        }

    }

    public function approveTrainingApplicant($training_id, $applicant_id)
    {
        if(Gate::allows('admin')){
            $training = TrainingsAvailable::find($training_id);
            $applicant = TrainingApplicant::find($applicant_id);
    
           if($training != null && $applicant != null){
                    $start_date = explode('-', $training->start_date);
                    $to_date = explode('-', $training->to_date);
                    $f_yr = $start_date[0];
                    $f_month = $start_date[1];
                    if($start_date[2] < 10){
                        $str = strval($start_date[2]);
                        if(strlen($str) == 2){
                            if($str[0] != 0){
                                $f_day = $start_date[2];
                            }else{
                                $f_day = $str[1];
                            }
                        }
                    }else{
                        $f_day = $start_date[2];
                    }
            
                    $t_yr = $to_date[0];
                    $t_month = $to_date[1];
                    if($to_date[2] < 10){
                        $t_str = strval($to_date[2]);
                        if(strlen($t_str) == 2){
                            if($t_str[0] != 0){
                                $t_day = $to_date[2];
                            }else{
                                $t_day = $t_str[1];
                            }
                        }
                    }else{
                        $t_day = $to_date[2];
                    }
                    
                    if($t_yr >= $f_yr){
                        for($i = $f_yr; $i <= $t_yr; $i++){
                            $start_month = 1;
                            $end_month = 12;
                
                            if($f_yr == $i){
                                $start_month = $f_month;
                            }
                            
                            if($t_yr == $i){
                                $end_month = $t_month;
                            }
                            
                            for($a = $start_month; $a <= $end_month; $a++){
                            $sched = [];
                                if($a == 1){
                                    $sched = January::where('employee_id', $applicant->employee_id)
                                                        ->where('year', $i)->first();
                                }else if($a == 2){
                                    $sched = February::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 3){
                                    $sched = March::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 4){
                                    $sched = April::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 5){
                                    $sched = May::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 6){
                                    $sched = June::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 7){
                                    $sched = July::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 8){
                                    $sched = August::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 9){
                                    $sched = September::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 10){
                                    $sched = October::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 11){
                                    $sched = November::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }else if($a == 12){
                                    $sched = December::where('employee_id', $applicant->employee_id)
                                    ->where('year', $i)->first();
                                }
                                        $f_dy = 1;
                                        $t_dy = cal_days_in_month(CAL_GREGORIAN, $a, $i); 
                
                                        if($a == $f_month && $i == $f_yr){
                                            $f_dy = $f_day;
                                        }
                                        
                                        if($a == $t_month && $i == $t_yr){
                                            $t_dy = $t_day;
                                        }
                
                
                                        for($b = $f_dy; $b <= $t_dy; $b++){
                
                                            $sched->$b = 'On Training';
                                        }
                                        $sched->save();
                        }
                
                    }
                    $applicant->status = 'approved';
                    $applicant->save();
                    $user = User::where('employee_id', $applicant->employee_id)->first();
                    $content = 'TRAININGS';
                    $route_name = "employee.training";
                    $from_date = $training->start_date;
                    $to_date = $training->to_date;
                    $user->notify(new TrainingApplicantApprovedNotification($user->employee_id, $applicant->training_id,$training->training_name,$content,$route_name, $from_date, $to_date));
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

       $this->reset('training');
       $this->reset('trainingModal');
    }
    public function showTrainingModel($id)
    {
        $this->training = TrainingsAvailable::findOrFail($id);
        $this->trainingModal = true;
        
    }

    public function deleteWebsite($id)
    {
        if(Gate::allows('admin')){
            $website = Website::find($id);
            if($website){
                $website->delete();
                session()->flash('success', 'Delete successful.');
            }else{
             session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }
    public function deleteEbook($id)
    {
        if(Gate::allows('admin')){
            $ebook = EBook::find($id);
            if($ebook){
                if (File::exists(public_path('storage/learning-materials/ebook/'.$ebook->ebook_file_name))) {
                    File::delete(public_path('storage/learning-materials/ebook/'.$ebook->ebook_file_name));
                    $ebook->delete();
                    session()->flash('success', 'Delete successful.');
                }else{
                    $ebook->delete();
                    session()->flash('success', 'Delete successful.');
                }
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }
    }
    public function deleteVideo($id)
    {
        if(Gate::allows('admin')){
            $video = Video::find($id);
            if($video){
                if (File::exists(public_path('storage/learning-materials/video/'.$video->video_file_name))) {
                    File::delete(public_path('storage/learning-materials/video/'.$video->video_file_name));
                    $video->delete();
                    session()->flash('success', 'Delete successful.');
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
    public function websites()
    {
        $this->learning_materials_content = 'WEBSITES';
    }
    public function videos()
    {
        $this->learning_materials_content = 'VIDEOS';
    }
    
    public function ebooks()
    {
        $this->learning_materials_content = 'EBOOKS';

    }
    public function previewEbooks($id)
    {
        $ebook = Ebook::find($id);
        if($ebook != null){
            $this->previewEbook = '/storage/learning-materials/ebook/'.$ebook->ebook_file_name;
            $this->previewModal = true;
        }
    }
    public function addWebsite()
    {
        $this->validate([
            'website_name' => 'required',
            'website_link' => 'required',
            'website_description' => 'required'
        ]);

        if(Gate::allows('admin')){
            $website = Website::create([
                'website_name' => $this->website_name,
                'website_description' => $this->website_description,
                'website_link' => $this->website_link,
            ]);

            if($website != null){
                session()->flash('success', 'Website added.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');

            }

        }else{
            session()->flash('failed', 'Failed, please try again later.');

        }

        $this->reset('website_name');
        $this->reset('website_description');
        $this->reset('website_link');
        $this->reset('ElearningMaterialModal');


    }  

    public function addEbook()
    {
        $this->validate([
            'ebook_name' => 'required',
            'ebook_file' => 'required|mimes:pdf,e.pub,mobi'
        ]);
        if(Gate::allows('admin')){
            $ebook_name = $this->ebook_file->getClientOriginalName();
            $this->ebook_file->storeAs('/public/learning-materials/ebook/', $ebook_name);
            $ebook = Ebook::create([
                'ebook_name' => $this->ebook_name,
                'ebook_file_name' => $ebook_name
            ]);
            
            if($ebook_name != null){
                session()->flash('success', 'Ebook added.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');

            }

        }else{
            session()->flash('failed', 'Failed, please try again later.');

        }

        $this->reset('ebook_name');
        $this->reset('ebook_file');
        $this->reset('ElearningMaterialModal');

    }

    public function ebook()
    {
        $this->ElearningMaterialModal_content = 'EBOOK';
    }

    public function video()
    {
        $this->ElearningMaterialModal_content = 'VIDEO';
    }

    public function website()
    {
        $this->ElearningMaterialModal_content = 'WEBSITE';
    }
    public function showAddELearningMaterialsModal()
    {
        $this->ElearningMaterialModal = true;
    }
    public function addTraining()
    {
        $this->validate([
            'training_name' => 'required',
            'department' => 'required',
            'start_date' => 'required',
            'to_date' => 'required',
            'training_description' => 'required',
        ]);

        if(Gate::allows('admin')){
            $training = TrainingsAvailable::create([
                'training_name' => $this->training_name,
                'department' => $this->department . ' Department',
                'start_date' => $this->start_date,
                'to_date' => $this->to_date,
                'training_description' => $this->training_description
            ]);
    
            if($training != null){
                $users = User::where('department', $this->department . ' Department')->get();
                foreach($users as $key => $user){
                    $route_name = 'employee.training';
                    $content = 'TRAININGS';
                    $user->notify(new TrainingNotification($this->department .' Department', $training->id, $route_name, $content));
                }
                session()->flash('success', 'Training posted.');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }


        $this->reset('training_name');
        $this->reset('department');
        $this->reset('start_date');
        $this->reset('to_date');
        $this->reset('training_name');
        $this->reset('addTrainingModal');

    }

    public function showAddTrainingModal()
    {
        $this->addTrainingModal = true;
    }
    public function learningMaterials()
    {
        $this->training_content = 'LEARNINGMATERIALS';
    }

    public function trainings()
    {
        $this->training_content = 'TRAININGS';
    }
    public function ebookLimit(){
            if($this->take_ebook == null){
                $this->take_ebook += 6;
            }else{
                $this->take_ebook += 3;
            }
    }

    public function videoLimit(){
        if($this->take_video == null){
            $this->take_video += 6;
        }else{
            $this->take_video += 3;
        }
    }
    public function websiteLimit(){
        if($this->take_website == null){
            $this->take_website += 6;
        }else{
            $this->take_website += 3;
        }
    }
    public function render()
    {
        $this->training_availables = TrainingsAvailable::orderBy('created_at', 'desc')->get();
         if ($this->training_content == null) {
         $this->training_content = 'TRAININGS';
         }
        if($this->ElearningMaterialModal_content == null){
            $this->ElearningMaterialModal_content = 'EBOOK';
        }

        if($this->learning_materials_content == null){
            $this->learning_materials_content = 'EBOOKS';
        }

      

        if($this->search_ebook != null){
            if($this->take_ebook == null){
                $this->e_books = Ebook::where('ebook_name', 'LIKE', $this->search_ebook)
                                        ->orderBy('ebook_name', 'asc')->take(3)->get();
            }else{
                $this->e_books = Ebook::where('ebook_name', 'LIKE', $this->search_ebook)
                                        ->orderBy('ebook_name', 'asc')->take($this->take_ebook)->get();
            }
        }else{
            if($this->take_ebook == null){
                $this->e_books = Ebook::orderBy('ebook_name', 'asc')->take(3)->get();
            }else{
                $this->e_books = Ebook::orderBy('ebook_name', 'asc')->take($this->take_ebook)->get();
            }
        }

        if($this->search_videos != null){
            if($this->take_video == null){
                $this->e_videos = Video::where('video_name', 'LIKE', $this->search_videos)
                                        ->orderBy('video_name', 'asc')->take(3)->get();
            }else{
                $this->e_videos = Video::where('video_name', 'LIKE', $this->search_videos)
                                    ->orderBy('video_name', 'asc')->take($this->take_video)->get();
            }
        }else{
            if($this->take_video == null){
                $this->e_videos = Video::orderBy('video_name', 'asc')->take(3)->get();
            }else{
                $this->e_videos = Video::orderBy('video_name', 'asc')->take($this->take_video)->get();
            }       
        }

        if($this->search_websites != null){
            if($this->take_website == null){
                $this->e_websites = Website::where('website_name', 'LIKE', $this->search_websites)
                                            ->orderBy('website_name', 'asc')->take(3)->get();
            }else{
                $this->e_websites = Website::where('website_name', 'LIKE', $this->search_websites)
                                            ->orderBy('website_name', 'asc')->take($this->take_website)->get();
            }
        }else{
            if($this->take_website == null){
                $this->e_websites = Website::orderBy('created_at', 'desc')->take(3)->get();
            }else{
                $this->e_websites = Website::orderBy('website_name', 'asc')->take($this->take_website)->get();
            }
             
        }
    
    
    
     
       

        return view('livewire.users.hrofficer.trainings');
    }
}
