<?php

namespace App\Livewire\Users\Employee;

use App\Models\EmployeeInformation;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCities;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use App\Models\TwoZeroOneFile;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{

    use WithFileUploads;

    public $editInformationModal = false;
    public $birthday;
    public $age;
    public $address;
    public $postal_code;
    public $mobile_number;
    public $editProfilePhotoModal = false;
    public $checker;
    //in livewire 3 this is the realtime validation
    #[Rule('mimes:jpg,jpeg,png,tmp,bng')]
    public $image;
    public $content;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public $file_name;
    public $parameter_id;

    public $regions;
    public $u_region;
    public $provinces;
    public $u_province;
    public $cities;
    public $u_city;
    public $brgys;
    public $u_brgy;
    public $showUploadModal = false;
    #[Rule('required')]
    public $requirement_name;
    #[Rule('required|mimes:jpeg,jpg,png,bng,docx,pdf')]
    public $file_image;
    public $specify;
    public $twozeroonefiles;
    public $other_requirements_file_name = [];
    
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

    public function downloadOthers($a)
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

    public function downloadResume($a)
    {
        if(File::exists(public_path('/storage/employee-201-file/'. $a))){
            return response()->download(public_path('/storage/employee-201-file/'. $a));
        }else{
            session()->flash('failed', 'Failed to download please try again later.');
        }
    }


    public function requirementUpload()
    {
        if(!empty($this->requirement_name)){
                if($this->requirement_name != 'others'){
                    $this->validate([
                        'requirement_name' => 'required',
                        'file_image' => 'required|mimes:jpeg,jpg,png,bng,docx,pdf',
                    ]);
                    $image = $this->file_image->getClientOriginalName();
                    $store = $this->file_image->storeAs('/public/employee-201-file/',  auth()->user()->employee_id . '-' .$image );
                        if(auth()->user()->two_zero_one_file){
                            $files = TwoZeroOneFile::where('employee_id', auth()->user()->employee_id)->first();
                            $column_name = $this->requirement_name;
                            if($files->$column_name != null){
                                if(File::exists(public_path('storage/employee-201-file/'.$files->$column_name))){
                                    File::delete(public_path('storage/employee-201-file/'.$files->$column_name));
                                    $files->$column_name = auth()->user()->employee_id . '-' .$image;
                                    $files->save();
                                    session()->flash('success', 'File uploaded');
                                }else{
                                    session()->flash('failed', 'Failed, please try again later');
                                }
                                
                            }else{
                                $files->$column_name =  auth()->user()->employee_id . '-' .$image;
                                $files->save();
                                session()->flash('success', 'File uploaded');
                            }
                        }else{
                            $file = TwoZeroOneFile::create([
                                'employee_id' => auth()->user()->employee_id,
                            ]);
                            $column_name = $this->requirement_name;
                            $file->$column_name =  auth()->user()->employee_id .'-' . $image;
                            $file->save();
                            session()->flash('success', 'File uploaded');
                        }
                }elseif($this->requirement_name == 'others'){
                    $this->validate([
                        'requirement_name' => 'required',
                        'file_image' => 'required|mimes:jpeg,jpg,png,bng,docx,pdf',
                        'specify' => 'required'
                    ]);
                    $image = $this->file_image->getClientOriginalName();
                    $store = $this->file_image->storeAs('/public/employee-201-file/',  auth()->user()->employee_id . '+' .$image );
                    $column_name = $this->requirement_name;
    
                    if(auth()->user()->two_zero_one_file){
                        $files = TwoZeroOneFile::where('employee_id', auth()->user()->employee_id)->first();
                        $data_arr = explode('(hris)', $files->others);
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
                        $data_name = $name . '='. auth()->user()->employee_id . '+' .$image .'(hris)'; 
                        $files->$column_name = $a . $data_name;
                        $files->save();
                    }else{
                        $name = $this->specify;
                        $data_name = $name . '='. auth()->user()->employee_id . '+' .$image .'(hris)'; 
                        $column_name = $this->requirement_name;
                        $files->$column_name .= $data_name;
                        $files->save();
                    }
                   
                        
                    }else{
    
                        $files = TwoZeroOneFile::create([
                            'employee_id' => auth()->user()->employee_id
                        ]);
                        
                        $name = $this->specify;
                        $data_name = $name . '='. auth()->user()->employee_id . '+' .$image .'(hris)'; 
                        $column_name = $this->requirement_name;
                        $files->$column_name = $data_name;
                        $files->save();
                        
                        
                    }
    
                }
        }
                    
            $this->reset('requirement_name');
            $this->reset('file_image');
            $this->reset('showUploadModal');
        

        
    }

    public function uploadFile()
    {
        $this->showUploadModal = true;
    }

    public function mount($cid, $content)
    {
        if($cid != null){
            $this->parameter_id = $cid;
        }

        if($content != null){
            $this->content = $content;
        }
        if(auth()->user()->two_zero_one_file){
            if(auth()->user()->two_zero_one_file->others){
                foreach (explode('(hris)', auth()->user()->two_zero_one_file->others) as $key => $file) {
                    $a = explode('=', $file);
                    if($a[0] != ""){
                        array_push($this->other_requirements_file_name, $a);
                    }
                }
            }
        }
    }



    public function information()
    {
        $this->content = 'INFORMATION';
    }

    public function showcertificates()
    {
        $this->content = '201file';
    }

    public function removePhoto()
    {
        if(auth()->user()->profile_photo_path != null){
            if(File::exists(public_path('storage/employee-media/'.auth()->user()->profile_photo_path))){
                File::delete(public_path('storage/employee-media/'.auth()->user()->profile_photo_path));
                $user = User::where('employee_id', auth()->user()->employee_id)->first();
                if($user){
                    $user->profile_photo_path = null;
                    $user->save();
                }
            }
        }
        $this->dispatch('refreshComponent');
        $this->reset();
    }

    public function saveProfilePhoto()
    {
        if(isset($this->image)){
            $this->validate([
                'image' => 'mimes:jpg,jpeg,png,tmp,bng'
            ]);
            $name = $this->image->getClientOriginalName();
            $user = User::where('employee_id', auth()->user()->employee_id)->first();

            if($user){
                if($user->profile_photo_path != null){
                    if (File::exists(public_path('storage/employee-media/'.$user->profile_photo_path))) {
                        File::delete(public_path('storage/employee-media/'.$user->profile_photo_path));
                        $user->profile_photo_path = $name;
                        $user->save();
                    }
                }else{
                    $user->profile_photo_path = $name;
                    $user->save();
                }
            $this->image->storeAs('/public/employee-media/', $name);
            $this->dispatch('refreshComponent');
            $this->reset();
            }

        }
    }



    public function editProfilePhoto()
    {
        $this->editProfilePhotoModal = true;
    }


    public function editEmployee()
    {
        $this->editInformationModal = true;
        if(auth()->user()->employee_information){
            $this->birthday = auth()->user()->employee_information->birthday;
            $this->age = auth()->user()->employee_information->age;
            $this->address = auth()->user()->employee_information->address;
            $this->u_city = auth()->user()->employee_information->city;
            $this->u_province = auth()->user()->employee_information->province;
            $this->u_brgy = auth()->user()->employee_information->barangay;
            $this->u_region = auth()->user()->employee_information->region;
            $this->postal_code = auth()->user()->employee_information->postal_code;
            $str = strval(auth()->user()->employee_information->mobile_number);
            $this->mobile_number = (int) substr(auth()->user()->employee_information->mobile_number, 2);
        }
    }
    
    public function saveInformation()
    {

        $employeeInformation = EmployeeInformation::where('employee_id', auth()->user()->employee_id)->first();
            if($employeeInformation != null){
                if(Gate::allows('employee-information', $employeeInformation)){
                    if($employeeInformation != null){
                        $employeeInformation->birthday = $this->birthday;
                        $employeeInformation->age = $this->age;
                        $employeeInformation->address = $this->address;
                        $employeeInformation->city = $this->u_city;
                        $employeeInformation->postal_code = $this->postal_code;
                        $employeeInformation->province = $this->u_province;
                        $employeeInformation->region = $this->u_region;
                        $employeeInformation->barangay = $this->u_brgy;
                        $employeeInformation->postal_code = $this->postal_code;
                        $num = strval($this->mobile_number);
                        if(strlen($num) == 10){
                            $employeeInformation->mobile_number = 63 . $this->mobile_number;
                        }elseif(strlen($num) == 1){
                            $m_number = intval(substr($num, 1));
                            $employeeInformation->mobile_number = 63 . $m_number;
                        }
                        $employeeInformation->save();
                        session()->flash('success', 'Employee information saved.');
                    }
                }else{
                    session()->flash('failed', 'Failed, please try again later.');
                }
            }else{
                $employee_information = EmployeeInformation::create([
                    'employee_id' => auth()->user()->employee_id,
                    'birthday' =>$this->birthday,
                    'age' => $this->age,
                    'address' => $this->address,
                    'city' => $this->city,
                    'province' => $this->u_province,
                    'barangay' => $this->u_brgy,
                    'region' => $this->u_region,
                    'postal_code' => $this->postal_code,
                ]);

                $num = strval($this->mobile_number);
                    if(strlen($num) == 10){
                        $employee_information->mobile_number = 63 . $this->mobile_number;
                    }elseif(strlen($num) == 11){
                        $m_number = intval(substr($num, 1));
                        $employee_information->mobile_number = 63 . $m_number;
                    }
                $employee_information->save();
                session()->flash('success', 'Employee information saved.');

            }
        
        $this->reset();

        
    }
    public function showTrainings()
    {
        $this->content = 'TRAININGS';
    }
    public function showBenefits()
    {
        $this->content = 'BENEFITS';
    }
    public function render()
    {
        if (isset($this->image)) {
            $ex = $this->image->getClientOriginalExtension();
                $this->checker = $ex;
        }

        if($this->content == null){
            $this->content = 'INFORMATION';
        }

        $this->regions = PhilippineRegion::get();
            if($this->u_region != null){
                $region = PhilippineRegion::where('region_description', $this->u_region)->first();
                $this->provinces = PhilippineProvince::where('region_code', $region->region_code)->get();
                if($this->u_province != null){
                    $prov = PhilippineProvince::where('region_code', $region->region_code)
                                                ->where('province_description', $this->u_province)->first();
                  if($prov != null){
                    $this->cities = PhilippineCities::where('region_description', $region->region_code)    ->where('province_code', $prov->province_code)->get();     
                    if($this->u_city != null){
                        $city = PhilippineCities::where('region_description', $region->region_code)
                                                    ->where('city_municipality_description', $this->u_city)->first();
                       if($city != null){
                        $this->brgys = PhilippineBarangay::where('region_code', $city->region_description)
                        ->where('province_code', $city->province_code)
                        ->where('city_municipality_code', $city->city_municipality_code)->get();
                            } 
                       }
                }
                  }
            }


        return view('livewire.users.employee.profile');
    }
}
