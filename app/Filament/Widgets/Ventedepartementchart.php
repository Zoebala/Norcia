<?php

namespace App\Filament\Widgets;

use App\Models\Annee;
use App\Models\Sortie;
use App\Models\Produit;
use App\Models\Departement;
use Filament\Widgets\ChartWidget;

class Ventedepartementchart extends ChartWidget
{
    protected static ?string $heading = 'Sorties/Ventes Journalières par Département';
    protected static bool $isLazy = false;
    protected static ?int $sort = 10;

    public static function canView(): bool
    {
        if(Auth()->user()->hasRole(["Admin","PDG","DCom"])){
            return Annee::isActive();
        }
        return false;
    }


    protected function getData(): array
    {
        $Departements=Departement::get("lib");
        $tableau=[];$DepartId=[];$EffectifparDepartement=[];
        //mise des valeurs de l'objet dans la variable tableau
        foreach ($Departements as $Depart) {
            $tableau[]=$Depart->lib;
        }


        $Departements=Departement::get(["lib","id"]);
        //récupération des clefs de Departements
        foreach ($Departements as $Depart){
            $DepartId[]=$Depart->id;
        }
        //récupération des effectifs par section pour l'année en cours

        foreach($DepartId as $index){

            $EffectifparDepartement[]=Sortie::join("departements","departements.id","sorties.departement_id")
                                            ->join("annees","annees.id","sorties.annee_id")
                                            ->whereRaw("Date(sorties.created_at)=DATE(now())")
                                            ->where("annees.id",session('Annee_id') ?? 1)
                                            ->where("departements.id",$index)
                                            ->count();
        }


        return [
            'datasets' => [
                [
                    'label' => 'Nombre de Sorties/ventes journalières par Département',
                    'data' => $EffectifparDepartement,
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
