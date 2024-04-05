<?php

namespace App\Livewire\Users\Employee;

use App\Models\April;
use App\Models\August;
use App\Models\December;
use App\Models\Ebook;
use App\Models\Favorites;
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
use App\Notifications\TrainingApplicantNotification;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Trainings extends Component
{
    public $take_ebook;
    public $take_video;
    public $take_website;
    public $take_favorites;
    public $training_availables;
    public $training_content = '';
    public $learning_materials_content = '';
    public $e_books;
    public $e_videos;
    public $e_websites;
    public $search_ebook;
    public $search_videos;
    public $search_websites;

    public $favorites;
    public $previewEbook;
    public $previewModal = false;
    protected $fillable = ['refreshComponent' => '$refresh'];
    public $parameter_id;
    public function mount($id, $content)
    {
        if($content != null){
            $this->training_content = $content;
        }

        if($id != null){
            $this->parameter_id = $id;
        }
        
    }

    public function cancelApplication($training_id){
        $application = TrainingApplicant::where('training_id', $training_id)    
                                            ->where('employee_id', auth()->user()->employee_id)->first();
        if($application != null){
            if(Gate::allows('cancel-training-application', $application)){
                $application->delete();
                session()->flash('success', 'Canceled');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        }else{
            session()->flash('failed', 'Failed, please try again later.');
        }                                    
    }

    public function previewEbooks($id)
    {
        $ebook = Ebook::findOrFail($id);
        $this->previewEbook = '/storage/learning-materials/ebook/'.$ebook->ebook_file_name;
        $this->previewModal = true;
    }

    public function removeToFavorites($id, $type)
    {
            $favorite = Favorites::where('employee_id', auth()->user()->employee_id)->where('type', $type)
                                    ->where('learning_id', $id)->first();
            if($favorite != null){
                $favorite->delete();
                session()->flash('success', 'Removed');
            }else{
                session()->flash('failed', 'Failed, please try again later.');
            }
        
        
        $this->dispatch('refreshComponent');
    }
    public function addToFavorites($id, $type)
    {
        if($type == 'website'){
            $website = Website::findOrFail($id);
            $favorite = Favorites::create([
                'employee_id' => auth()->user()->employee_id,
                'learning_id'=> $website->id,
                'type' => $type,
                'name' => $website->website_name,
                'file_name' => $website->website_link,
                'description' => $website->website_description,
            ]);

        }elseif($type == 'ebook'){
            $ebook = Ebook::findOrFail($id);
            $favorite = Favorites::create([
                'employee_id' => auth()->user()->employee_id,
                'learning_id'=> $ebook->id,
                'type' => $type,
                'name' => $ebook->ebook_name,
                'file_name' => $ebook->ebook_file_name,
            ]);
        }elseif($type == 'video'){
            $video = Video::findOrFail($id);
            $favorite = Favorites::create([
                'employee_id' => auth()->user()->employee_id,
                'learning_id'=> $video->id,
                'type' => $type,
                'name' => $video->video_name,
                'file_name' => $video->video_file_name,
            ]);
        }

        $this->dispatch('refreshComponent');
    }
    public function ebooks()
    {
        $this->learning_materials_content = 'EBOOKS';
    }

    public function videos()
    {
        $this->learning_materials_content = 'VIDEOS';
    }

    public function favorite()
    {
        $this->learning_materials_content = 'FAVORITES';

    }

    public function websites()
    {
        $this->learning_materials_content = 'WEBSITES';
    }

    public function apply($id)
    {
        $training = TrainingsAvailable::find($id);
        if($training != null){
            if(Gate::allows('employee')){
                $arr = explode('-', $training->start_date);
                $array = explode('-', $training->to_date);
                $f_month = $arr[1];
                $t_month = $array[1];
                if($arr[0] == $array[0]){
                    if($training->status != 'Ended'){
                        $apply = TrainingApplicant::create([
                            'training_id' => $training->id,
                            'employee_id' => auth()->user()->employee_id
                        ]);
    
                        for($i = $f_month; $i <= $t_month; $i++){
                            $sched = [];
                             if($i == 1){
                            $sched = January::where('employee_id', auth()->user()->employee_id)
                                                ->where('year', $arr[0])->first();
                        }else if($i == 2){
                            $sched = February::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 3){
                            $sched = March::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 4){
                            $sched = April::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 5){
                            $sched = May::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 6){
                            $sched = June::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 7){
                            $sched = July::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 8){
                            $sched = August::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 9){
                            $sched = September::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 10){
                            $sched = October::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 11){
                            $sched = November::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }else if($i == 12){
                            $sched = December::where('employee_id', auth()->user()->employee_id)
                            ->where('year', $arr[0])->first();
                        }
        
                        
                        if($sched == null){
                                if($i == 1){
                                    $sched = January::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 2){
                                    $sched = February::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 3){
                                    $sched = March::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 4){
                                    $sched = April::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 5){
                                    $sched = May::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 6){
                                    $sched = June::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 7){
                                    $sched = July::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 8){
                                    $sched = August::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 9){
                                    $sched = September::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 10){
                                    $sched = October::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 11){
                                    $sched = November::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }elseif($i == 12){
                                    $sched = December::create([
                                        'employee_id' => auth()->user()->employee_id,
                                        'year' => $arr[0]
                                    ]);
                                }
                            }
        
                        }
    
    
    
                            $route_name = "admin.trainings";
                            $content = "TRAININGS";
                            $admin = User::where('role', 2)->first();
                            $admin->notify(new TrainingApplicantNotification(auth()->user()->employee_id, $training->id,  $training->training_name, $content, $route_name));
                            session()->flash('success', 'Applied successful.');
        
                    }else{
                        session()->flash('failed', 'Failed, this  training has already ended.');
                    }
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
    public function learningMaterials()
    {
        $this->training_content = 'LEARNINGMATERIALS';
    }

    public function trainings()
    {
        $this->training_content = 'TRAININGS';
    }

    public function moreEbook(){
        if($this->take_ebook == null){
            $this->take_ebook += 6;
        }else{
            $this->take_ebook += 3;
        }
    }

    public function moreVide(){
        if($this->take_video == null){
            $this->take_video += 6;
        }else{
            $this->take_video += 3;
        }
    }
    public function moreWebsite(){
        if($this->take_website == null){
            $this->take_website += 6;
        }else{
            $this->take_website += 3;
        }
    }

    public function moreFavorites()
    {
        if($this->take_favorites == null){
            $this->take_favorites += 6;
        }else{
            $this->take_favorites += 3;

        }
    }
    public function render()
    {

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



        if($this->learning_materials_content == null){
            $this->learning_materials_content = 'EBOOKS';
        }

        if ($this->training_content == null) {
             $this->training_content = 'TRAININGS';
        }


        if($this->take_favorites == null){
            $this->favorites = Favorites::where("employee_id", auth()->user()->employee_id)->orderBy('created_at', 'desc')->take(3)->get();
        }else{
            $this->favorites = Favorites::where("employee_id", auth()->user()->employee_id)->orderBy('created_at', 'desc')->take($this->take_favorites)->get();
        }

        $this->training_availables = TrainingsAvailable::where('department', auth()->user()->department)->orderBy('created_at', 'desc')->get();
        return view('livewire.users.employee.trainings');
    }
}
