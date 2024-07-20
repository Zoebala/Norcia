<?php

namespace App\Livewire;

use Livewire\Component;

class Produit extends Component
{
    public function render()
    {
        return view('livewire.produit')->layoutData([
            "title"=>"Nos Produits",
            "pageTitle"=>"Produits",
        ]);
    }
}
