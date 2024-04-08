<?php

namespace App\Livewire\Users\Hrofficer;

use Livewire\Component;

class AdminMenu extends Component
{
    public $userExtend = false;

    public function userextend()
    {
       if($this->userExtend == false){
        $this->userExtend = true;
       }else if($this->userExtend == true){
        $this->userExtend = false;

       }
    }
    public function render()
    {
        return view('livewire.users.hrofficer.admin-menu');
    }
}
