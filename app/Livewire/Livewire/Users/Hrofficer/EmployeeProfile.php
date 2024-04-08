<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\Certificate;
use App\Models\TwoZeroOneFile;
use App\Models\User;
use App\Notifications\CertificateNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmployeeProfile extends Component
{

    use WithFileUploads;
    public $user;
    public $content;
    public $certificates;
    public $addCertificatesModal = false;

    #[Rule('required')]
    public $certificate_name;
    #[Rule('required|max:1000')]
    public $certificate_info;
    #[Rule('required|mimes:pdf')]
    public $file;
    public $file_name;
    public $previewCertificate = false;
    public $showChecklistModal = false;
    public $other_requirements = [];
    public $other_requirements_file_name = [];
    public $showUploadModal = false;
    public $requirement_name;
    #[Rule('required|mimes:jpeg,jpg,png,bng,docx,pdf')]
    public $file_upload;
    public $specify;

    public function requirementUpload()
    {
        
        if(!empty($this->requirement_name)){
            if($this->requirement_name == 'others'){
                $this->validate([
                    'requirement_name' => 'required',
                    'file_upload' => 'required|mimes:jpeg,jpg,png,bng,docx,pdf',
                    'specify' => 'required'
                ]);
                $file = $this->file_upload->getClientOriginalName();
                $store = $this->file_upload->storeAs('/public/employee-201-file/', $this->user->employee_id . '+' .$file );
                $column_name = $this->requirement_name;
                if($this->user->two_zero_one_file){
                    $data = TwoZeroOneFile::where('employee_id', $this->user->employee_id)->first();
                    $data_arr = explode('(hris)', $this->user->two_zero_one_file->others);
                    $check = false;
                    foreach ($data_arr as $key => $value) {
                        $arr = explode('=', $value);
                        if(strtolower(trim($arr[0])) == strtolower(trim($this->specify))){
                            if(File::exists(public_path('storage/employee-201-file/'.$arr[1]))){
                                File::delete(public_path('storage/employee-201-file/'.$arr[1]));
                                $check = true;
                                unset($data_arr[$key]);
                            }
                        }
                    }

                    $a = "";
                    if($check == true){
                        foreach($data_arr as $key => $value){
                            $a .= $value.'(hris)';
                        }
                        $name = $this->specify;
                        $data_name = $name . '='. $this->user->employee_id . '+' .$file .'(hris)'; 
                        $data->$column_name = $a . $data_name;
                        $data->save();
                    }else{
                        $name = $this->specify;
                        $data_name = $name . '='. $this->user->employee_id . '+' .$file .'(hris)'; 
                        $data->$column_name .= $data_name;
                        $data->save();
                    }
                
                }else{
                    $two_zero_one_file = TwoZeroOneFile::create([
                        'employee_id' => $this->user->employee_id
                    ]);
                    
                    $two_zero_one_file->$column_name = $this->specify .'='. $this->user->employee_id . '+' .$file. '(hris)';
                    $two_zero_one_file->save();
                }

            }else{
                $this->validate([
                    'requirement_name' => 'required',
                    'file_upload' => 'required|mimes:jpeg,jpg,png,bng,docx,pdf',
                ]);
                $file = $this->file_upload->getClientOriginalName();
                $store = $this->file_upload->storeAs('/public/employee-201-file/', $this->user->employee_id . '+' .$file );
                $column_name = $this->requirement_name;
                if($this->user->two_zero_one_file){
                    $data = TwoZeroOneFile::where('employee_id', $this->user->employee_id)->first();
                    if($this->user->two_zero_one_file->$column_name != null){
                        if(File::exists(public_path('storage/employee-201-file/'.$data->$column_name))){
                            File::delete(public_path('storage/employee-201-file/'.$data->$column_name));
                         
                        }
                    }
                         $data->$column_name = $this->user->employee_id . '+' .$file;
                        $data->save();
                    
                }else{
                    $two_zero_one_file = TwoZeroOneFile::create([
                        'employee_id' => $this->user->employee_id
                    ]);
                    $two_zero_one_file->$column_name = $this->user->employee_id . '+' .$file;
                    $two_zero_one_file->save();
                }
            }
        }

        $this->reset('requirement_name');
        $this->reset('file_upload');
        $this->reset('showUploadModal');
    }
    public function showUploadFileModal()
    {
        $this->showUploadModal = true;
    }

    public function showChecklist()
    {
        $this->showChecklistModal = true;
    }
    
    public function downloadTor($a)
    {
        
        if(File::exists(public_path('/storage/employee-201-file/'. $a))){
            return response()->download(public_path('/storage/employee-201-file/'. $a));

        }else{
            session()->flash('failed', 'Failed to download please try again later.');
        }
    }
    public function downloadDiploma($a)
    {
        if(File::exists(public_path('/storage/employee-201-file/'. $a))){
            return response()->download(public_path('/storage/employee-201-file/'. $a));

        }else{
            session()->flash('failed', 'Failed to download please try again later.');
        }
    }
    public function downloadNbi($a)
    {
     
        if(File::exists(public_path('/storage/employee-201-file/'. $a))){
            return response()->download(public_path('/storage/employee-201-file/'. $a));

        }else{
            session()->flash('failed', 'Failed to download please try again later.');
        }
    }
    public function downloadSss($a)
    {
        if(File::exists(public_path('/storage/employee-201-file/'. $a))){
            return response()->download(public_path('/storage/employee-201-file/'. $a));

        }else{
            session()->flash('failed', 'Failed to download please try again later.');
        }
    }

    public function downloadTin($a)
    {
        if(File::exists(public_path('/storage/employee-201-file/'. $a))){
            return response()->download(public_path('/storage/employee-201-file/'. $a));

        }else{
            session()->flash('failed', 'Failed to download please try again later.');
        }
    }

    public function downloadPhilhealth($a)
    {
        if(File::exists(public_path('/storage/employee-201-file/'. $a))){
            return response()->download(public_path('/storage/employee-201-file/'. $a));

        }else{
            session()->flash('failed', 'Failed to download please try again later.');
        }
    }

    public function downloadContracts($a)
    {
        if(File::exists(public_path('/storage/employee-201-file/'. $a))){
            return response()->download(public_path('/storage/employee-201-file/'. $a));

        }else{
            session()->flash('failed', 'Failed to download please try again later.');
        }
    }


    public function show201Files()
    {
        $this->content = '201FILES';
    }

    public function uploadCertificate()
    {
        $this->validate([
            'certificate_name' => 'required',
            'certificate_info' => 'required|max:1000',
            'file' => 'required',
        ]);

        if(Gate::allows('admin')){
            $name = $this->file->getClientOriginalName();
            $certificate = Certificate::create([
                'employee_id' => $this->user->employee_id,
                'certificate_name' => $this->certificate_name,
                'certificate_info' => $this->certificate_info,
                'certificate_file_name' => $this->user->employee_id. $name   
            ]);

            if($certificate){
                $this->file->storeAS('/public/employee-certificates',  $this->user->employee_id . $name );
                $this->user->notify(new CertificateNotification($this->user->employee_id, $certificate->id, $this->certificate_name, 'CERTIFICATES', 'employee.profile'));
            }
        }else{
            session()->flash('Failed', 'Failed, please try again later.');
        }

        $this->reset('addCertificatesModal');
        $this->reset('certificate_name');
        $this->reset('certificate_info');
        $this->reset('file');
    }

    public function showAddCertificatesModal()
    {   
        $this->addCertificatesModal = true;
    }
    public function showTrainings()
    {
        $this->content = 'TRAININGS';
    }
    public function showBenefits()
    {
        $this->content = 'BENEFITS';
    }
    
    public function information()
    {
        $this->content = 'INFORMATION';
    }

    public function showcertificates()
    {
        $this->content = 'CERTIFICATES';
    }

    public function downloadOthers($a)
    {
        return response()->download(public_path('/storage/employee-201-file/'. $a));
    }

    public function mount($eid)
    {
        $this->user = User::where('employee_id', $eid)->first();  
            if($this->user->two_zero_one_file){
               if($this->user->two_zero_one_file->others){
                foreach (explode('(hris)', $this->user->two_zero_one_file->others) as $key => $file) {
                    $a = explode('=', $file);
                    array_push($this->other_requirements, $a[0]);
                    if($a[0] != ""){
                        array_push($this->other_requirements_file_name, $a);
                    }
            }
               }
        }
    }

    public function render()
    {
        if($this->content == null){
            $this->content = 'INFORMATION';
        }

        
        return view('livewire.users.hrofficer.employee-profile');
    }
}
