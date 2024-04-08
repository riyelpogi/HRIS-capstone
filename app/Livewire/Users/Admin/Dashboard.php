<?php

namespace App\Livewire\Users\Admin;

use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{

    public $users;
    public $content;
    public $search;
    public function showApplicants()
    {
        $this->content = "APPLICANTS";

    }

    public function showEmployees()
    {
        $this->content = "EMPLOYEES";
    }

    public function showHrOfficers()
    {
        $this->content = "HROFFICERS";
    }

    public function render()
    {

        if($this->content == null){
            $this->content = "APPLICANTS";
            $this->users = User::where('role', 0)->get();
        }


        if($this->content == 'APPLICANTS'){
            if($this->search != null){
                $this->users = User::where('name', 'LIKE', '%'.$this->search.'%')->where('role', 0)->get();
            }else{
                $this->users = User::where('role', 0)->get();
            }
        }else if($this->content == 'EMPLOYEES'){
            if($this->search != null){
                $this->users = User::where('name', 'LIKE', '%'.$this->search.'%')->where('role', 1)->get();
            }else{
                $this->users = User::where('role', 1)->get();
            }
        }else if($this->content == 'HROFFICERS'){
            if($this->search != null){
                $this->users = User::where('name', 'LIKE', '%'.$this->search.'%')->where('role', 2)->get();
            }else{
                $this->users = User::where('role', 2)->get();
            }
        }


        return view('livewire.users.admin.dashboard');
    }
}
