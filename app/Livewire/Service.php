<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Departement;

class Service extends Component
{

    public $departements="";


    public function mount(){
        $this->departements=Departement::all();
    }
    public function render()
    {
        return view('livewire.service')->layoutData([
            "title"=>"Nos Services",
            "pageTitle"=>"Services"
        ]);
    }
}
