<?php

namespace App\Livewire;

use Livewire\Component;

class Service extends Component
{
    public function render()
    {
        return view('livewire.service')->layoutData([
            "title"=>"Nos Services",
            "pageTitle"=>"Services"
        ]);
    }
}
