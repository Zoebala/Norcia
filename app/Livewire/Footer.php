<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Departement;

class Footer extends Component
{
    public $services="";

    public function mount(){
        $this->services=Departement::all();
    }
    public function render()
    {
        return view('livewire.footer');
    }
}
