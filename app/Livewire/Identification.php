<?php

namespace App\Livewire;

use Livewire\Component;

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
