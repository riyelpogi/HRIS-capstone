<?php

namespace App\Livewire\Users\Applicant;

use App\Models\EmployeeInformation;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCities;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
use App\Models\TwoZeroOneFile;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;
    public $editInformationModal = false;
    public $birthday;
    public $age;
    public $address;
    public $city;
    public $postal_code;
    public $mobile_number;
    #[Rule('required|mimes:docx,pdf')]
    public $resume;
    public $regions;
    public $u_region;
    public $provinces;
    public $u_province;
    public $u_city;
    public $cities;
    public $brgys;
    public $u_brgy;
    public $content;
    public $showUploadModal = false;


    public function uploadResume()
    {
        $this->validate([
            'resume' => 'required|mimes:docx,pdf'
        ]);
        $name = $this->resume->getClientOriginalName();
        $store = $this->resume->storeAs('/public/resume-cv/', auth()->user()->id . $name);

        if(auth()->user()->employee_information){
            $info = EmployeeInformation::where('employee_id',auth()->user()->id)->first();
            if($info){
                $info->resume = auth()->user()->id . $name;
                $info->save();
                session()->flash('success','File Uploaded');
            }else{
                session()->flash('failed','Failed, please try again later.');

            }
        }else{
            $info = EmployeeInformation::create([
                'employee_id' => auth()->user()->id,
                'resume' => auth()->user()->id . $name
            ]);
            session()->flash('success','File Uploaded');

        }

        $this->reset('resume');
        $this->reset('showUploadModal');
    }


    public function uploadFile()
    {
        $this->showUploadModal = true;
    }

    public function showInformation()
    {
        $this->content = 'INFORMATION';
    }

    public function showFiles()
    {
        $this->content = '201FILES';
    }
    public function editApplicant()
    {
        $this->editInformationModal = true;
        if(auth()->user()->employee_information){
            $this->birthday = auth()->user()->employee_information->birthday;
            $this->age = auth()->user()->employee_information->age;
            $this->address = auth()->user()->employee_information->address;
            $this->u_city = auth()->user()->employee_information->city;
            $this->u_region = auth()->user()->employee_information->region;
            $this->u_brgy = auth()->user()->employee_information->barangay;
            $this->u_province = auth()->user()->employee_information->province;
            $this->postal_code = auth()->user()->employee_information->postal_code;
            $str = strval(auth()->user()->employee_information->mobile_number);
            $this->mobile_number = (int) substr(auth()->user()->employee_information->mobile_number, 2);
        }
    }
    
    public function saveInformation()
    {
        $user = User::findOrFail(auth()->user()->id);
            if(auth()->user()->employee_information){                          
              $user_information = EmployeeInformation::where('employee_id', auth()->user()->id)->first();
                $user_information->birthday = $this->birthday;
                $user_information->age = $this->age;
                $user_information->address = $this->address;
                $user_information->city = $this->u_city;
                $user_information->region = $this->u_region;
                $user_information->province = $this->u_province;
                $user_information->barangay = $this->u_brgy;
                $user_information->postal_code = $this->postal_code;
                if($this->mobile_number != null){
                    $num = strval($this->mobile_number);
                    if(strlen($num) == 10){
                        $user_information->mobile_number = 63 . $this->mobile_number;
                    }else if(strlen($num) == 11){
                        $number = substr($num, 1);
                        $user_information->mobile_number = 63 . $number;
                        
                    }
                }
                $user_information->save();
            }else{
                 if($this->mobile_number != null){
                    $num = strval($this->mobile_number);
                    if(strlen($num) == 10){
                        $number = 63 . $this->mobile_number;
                    }else if(strlen($num) == 11){
                        $number = 63 . substr($num, 1);
                    }
                $employee_information = EmployeeInformation::create([
                    'birthday' =>$this->birthday,
                    'age' => $this->age,
                    'address' => $this->address,
                    'city' => $this->u_city,
                    'province' => $this->u_province,
                    'region' => $this->u_region,
                    'barangay' => $this->u_brgy,
                    'postal_code' => $this->postal_code,
                    'mobile_number' => $number,
                ]);
            }else{
                $employee_information = EmployeeInformation::create([
                    'birthday' =>$this->birthday,
                    'age' => $this->age,
                    'address' => $this->address,
                    'city' => $this->u_city,
                    'province' => $this->u_province,
                    'region' => $this->u_region,
                    'barangay' => $this->u_brgy,
                    'postal_code' => $this->postal_code,
                ]);
            }
               
                    $employee_information->employee_id = auth()->user()->id;
                    $employee_information->save();

                session()->flash('success','Upload Successful.');
            }
         
     
        $this->reset();

        
    }

    public function render()
    {
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

        if($this->content == null){
            $this->content = 'INFORMATION';
        }

        return view('livewire.users.applicant.profile');
    }
}
