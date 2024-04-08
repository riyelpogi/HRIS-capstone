<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class LandingPage extends Component
{

    public $birthday_celebrants = [];

    public function render()
    {
        $arr = [];
        $users = User::where('role', '!=', 0)->get();
        foreach ($users as $key => $user) {
            if($user->employee_information != null){
                if($user->employee_information->birthday != null){
                    $bday = explode('-', $user->employee_information->birthday);
                    $month = $bday[1];
                    $day = $bday[2];
                    if(date('m-d', time()) == $month.'-'.$day){
                        if(!in_array($user->employee_id, $arr)){
                            array_push($arr, $user->employee_id);
                        }
                    }
                }
            }
            
        }


        $celebrants = User::where('role', '!=', 0)->get();
        foreach ($celebrants as $key => $celebrant) {
            if(in_array($celebrant->employee_id, $arr)){
                if(!in_array($celebrant->employee_id, $this->birthday_celebrants)){
                    $bday = explode('-', $celebrant->employee_information->birthday);
                    $this->birthday_celebrants[$celebrant->employee_id] = [
                        'name'=> $celebrant->name,
                        'employee_id'=> $celebrant->employee_id,
                        'position'=> $celebrant->position,
                        'department'=> $celebrant->department,
                        'profile'=> $celebrant->profile_photo_path,
                        'month' => $bday[1],
                        'day' => $bday[2],
                    ];
                }
            }
        }

        
        return view('livewire.users.landing-page');
    }
}
