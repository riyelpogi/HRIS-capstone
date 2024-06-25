<?php

namespace App\Livewire;

use Livewire\Component;

class EmployeeMenu extends Component
{
    public $content = 'WELCOME';

    public function attendance()
    {
        $this->content = 'ATTENDANCE';
    }

    public function render()
    {
        return view('livewire.employee-menu');
    }
}
