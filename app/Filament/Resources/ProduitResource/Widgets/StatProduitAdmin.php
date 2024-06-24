<?php

namespace App\Filament\Resources\ProduitResource\Widgets;

use App\Models\Sortie;
use App\Models\Produit;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatProduitAdmin extends BaseWidget
{

    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        return [
            Stat::make("Cumul Sorties", Sortie::join("elementssorties","elementssorties.sortie_id","sorties.id")
                                                ->where("annee_id",session("Annee_id")?? 1)->count())
            ->description("Cumul Nombre de Sorties")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-truck"),
            Stat::make("Produits Critiques", Produit::where("qte","<",100)->count())
            ->description("Nombre de Produit en rupture de stock")
            ->color("danger")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-shopping-bag"),
            Stat::make("Cumul Chiffre d'affaires",Sortie::join("departements","departements.id","sorties.departement_id")
                                                         ->join("elementssorties","elementssorties.sortie_id","sorties.id")
                                                        ->where("sorties.annee_id",session("Annee_id")?? 1)
                                                        ->SUM("elementssorties.total")." FC")
            ->description("Cumul Chiffre d'affaires")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-banknotes"),
        ];
    }

    public function getColumns(): int
    {
        return 3;
    }
}
