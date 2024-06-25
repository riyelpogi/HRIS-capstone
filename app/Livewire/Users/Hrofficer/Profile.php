<?php

namespace App\Livewire\Users\Hrofficer;

use App\Models\EmployeeInformation;
use App\Models\PhilippineBarangay;
use App\Models\PhilippineCities;
use App\Models\PhilippineProvince;
use App\Models\PhilippineRegion;
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
    public $cities;
    public $postal_code;
    public $mobile_number;
    #[Rule('mimes:jpg,jpeg,png,tmp')]
    public $image;
    public $editProfilePhotoModal = false;
    public $checker;
    public $provinces;
    public $regions;
    public $brgys;
    public $u_province;
    public $u_region;
    public $u_brgy;
    public $u_city;
    public function editProfilePhoto()
    {
        $this->editProfilePhotoModal = true;
    }

    public function saveProfilePhoto()
    {
        if(isset($this->image)){
            $this->validate([
                'image' => 'mimes:jpg,jpeg,png,tmp'
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
        $employee_information = EmployeeInformation::where('employee_id', auth()->user()->employee_id)->first();
        
        if($employee_information != null){
            if (Gate::allows('employee-information', $employee_information)) {
                    $employee_information->birthday = $this->birthday;
                    $employee_information->age = $this->age;
                    $employee_information->address = $this->address;
                    $employee_information->city = $this->u_city;
                    $employee_information->postal_code = $this->postal_code;
                    $employee_information->province = $this->u_province;
                    $employee_information->region = $this->u_region;
                    $employee_information->barangay = $this->u_brgy;
                    $num = strval($this->mobile_number);
                    if(strlen($num) == 10){
                        $employee_information->mobile_number = 63 . $this->mobile_number;
                    }else if(strlen($num) == 11 && $num[0] == '0'){
                        $pnum = intval(substr($num, 1));
                        $employee_information->mobile_number = 63 . $pnum;
                        $employee_information->save();
                    }
                    $employee_information->save();
                    session()->flash('success', 'Employee information saved.');
                }else{
                    session()->flash('failed', 'Failed, please try again later.');
                }
            }else{
                $employee_information = EmployeeInformation::create([
                    'employee_id' => auth()->user()->employee_id,
                    'birthday' =>$this->birthday,
                    'age' => $this->age,
                    'address' => $this->address,
                    'city' => $this->u_city,
                    'postal_code' => $this->postal_code,
                    'province' => $this->u_province,
                    'barangay' => $this->u_brgy,
                    'region' => $this->u_region,
                ]);
                $num = strval($this->mobile_number);
                if(strlen($num) == 10){
                    $employee_information->mobile_number = 63 . $this->mobile_number;
                    $employee_information->save();
                }else if(strlen($num) == 11 && $num[0] == '0'){
                    $pnum = intval(substr($num, 1));
                    $employee_information->mobile_number = 63 . $pnum;
                    $employee_information->save();
                }
        }
        $this->reset();
    }

    public function render()
    {
        if (isset($this->image)) {
            $ex = $this->image->getClientOriginalExtension();
                $this->checker = $ex;
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
        

        
        return view('livewire.users.hrofficer.profile');
    }
}
