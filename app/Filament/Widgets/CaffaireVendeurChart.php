<?php

namespace App\Filament\Widgets;

use App\Models\Sortie;
use App\Models\Vendeur;
use Filament\Widgets\ChartWidget;

class CaffaireVendeurChart extends ChartWidget
{
    protected static ?string $heading = 'Chiffre d\'affaires journalières par Vendeur';
    protected static bool $isLazy = false;
    protected static ?int $sort = 40;

    protected function getData(): array
    {
        $Vendeurs=Vendeur::get("nom");
        $tableau=[];$VendeurId=[];$EffectifparVendeur=[];
        //mise des valeurs de l'objet dans la variable tableau
        foreach ($Vendeurs as $Vendeur) {
            $tableau[]=$Vendeur->nom;
        }


        $Vendeurs=Vendeur::get(["nom","id"]);
        //récupération des clefs de Vendeurs
        foreach ($Vendeurs as $Vendeur){
            $VendeurId[]=$Vendeur->id;
        }
        //récupération des effectifs par section pour l'année en cours

        foreach($VendeurId as $index){

            $EffectifparVendeur[]=Sortie::join("departements","departements.id","sorties.departement_id")
                                            ->join("elementssorties","elementssorties.sortie_id","sorties.id")
                                            ->join("annees","annees.id","sorties.annee_id")
                                            ->whereRaw("Date(sorties.created_at)=DATE(now())")
                                            ->where("annees.id",session('Annee_id') ?? 1)
                                            ->where("sorties.vendeur_id",$index)
                                            ->sum("elementssorties.total");
        }


        return [
            'datasets' => [
                [
                    'label' => 'Chiffre d\'affaires journalières par Vendeur',
                    'data' => $EffectifparVendeur,
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
        return 'doughnut';
    }
}
