<?php

namespace App\Filament\Resources\ProduitResource\Widgets;

use App\Models\Produit;
use Filament\Widgets\ChartWidget;

class Caffaireproduitchart extends ChartWidget
{
    protected static ?string $heading = "Chiffres d'affaires Produits";
    protected static bool $isLazy = false;
    protected static ?int $sort = 40;

    protected function getData(): array
    {
        $Produits=Produit::get("lib");
        $tableau=[];$ProduitId=[];$EffectifparProduit=[];
        //mise des valeurs de l'objet dans la variable tableau
        foreach ($Produits as $Produit) {
            $tableau[]=$Produit->lib;
        }


        $Produits=Produit::get(["lib","id"]);
        //récupération des clefs de Produits
        foreach ($Produits as $Produit){
            $ProduitId[]=$Produit->id;
        }
        //récupération des effectifs par section pour l'année en cours

        foreach($ProduitId as $index){

            $EffectifparProduit[]=Produit::join("elementssorties","elementssorties.produit_id","produits.id")
                                          ->join("sorties","sorties.id","elementssorties.sortie_id")
                                          ->join("annees","annees.id","produits.annee_id")
                                          ->where("produits.annee_id",session('Annee_id')[0] ?? 1)
                                          ->whereProduit_id($index)->sum("elementssorties.total");
        }


        return [
            'datasets' => [
                [
                    'label' => 'Sorties Produits',
                    'data' => $EffectifparProduit,
                    // définition des couleurs pour les effectifs des sections
                    'backgroundColor' => [
                        'rgb(255,99,132)',
                        'rgb(54,162,235)',
                        'rgb(255,205,86)',
                        'red',
                        'gray',
                        'green',
                        'yellow',
                        'lightblue',

                    ],
                ],
            ],
            'labels' => $tableau,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
