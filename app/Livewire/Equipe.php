<?php

namespace App\Livewire;

use App\Models\Employe;
use Livewire\Component;

class Equipe extends Component
{
    public $membres="";

    public function mount(){
        $this->membres=Employe::join("fonctions","fonctions.id","employes.fonction_id")
                                ->get();
    }
    public function render()
    {
        return view('livewire.equipe');
    }
}
