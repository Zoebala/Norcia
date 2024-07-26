<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Departement;

class Identification extends Component
{
   
    public function render()
    {
        return view('livewire.identification')->layoutData([
            "title"=>"S'identifier",
            "pageTitle"=>"S'identifier",
        ]);
    }
}
