<?php

namespace App\Livewire;

use App\Models\Produit as ProduitModel;
use Livewire\Component;
use App\Models\Departement;

class Produit extends Component
{

    public $departements="";
    public $produits="";

    public function mount(){
        $this->departements=Departement::all();
        $this->produits=ProduitModel::join("departements","departements.id","produits.departement_id")
                        ->get(["produits.lib as Produit","produits.departement_id as Depart_id","produits.photo as ProdPhoto","produits.id as Prod_id"]);
        

    }
    public function render()
    {
        return view('livewire.produit')->layoutData([
            "title"=>"Nos Produits",
            "pageTitle"=>"Produits",
        ]);
    }
}
