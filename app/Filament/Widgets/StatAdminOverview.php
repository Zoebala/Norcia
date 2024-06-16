<?php

namespace App\Filament\Widgets;

use App\Models\Produit;
use App\Models\Pointvente;
use App\Models\Departement;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatAdminOverview extends BaseWidget
{

    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        return [
            //
            Stat::make("Departements", Departement::where("annee_id",session("Annee_id")??1)->count())
            ->description("Nos Départements")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-building-office"),
            Stat::make("Produits", Produit::where("annee_id",session("Annee_id")??1)->count())
            ->description("Nos Produits")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-shopping-bag"),
            Stat::make("Points de Vente", Pointvente::where("annee_id",session("Annee_id")??1)->count())
            ->description("Nos Points de Vente")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-home-modern"),
        ];
    }
}
