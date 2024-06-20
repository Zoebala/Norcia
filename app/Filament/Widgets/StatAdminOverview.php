<?php

namespace App\Filament\Widgets;

use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Employe;
use App\Models\Produit;
use App\Models\Presence;
use App\Models\Pointvente;
use App\Models\Production;
use App\Models\Departement;
use App\Models\Elementsentree;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatAdminOverview extends BaseWidget
{

    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        return [
            //
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
            Stat::make("Présence Journalière", Presence::where("annee_id",session("Annee_id")?? 1)
                                                        ->whereRaw("Date(presences.created_at)=DATE(now())")->count())
            ->description("Nombre d'employés présent")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-calendar-days"),
            Stat::make("Entrées Journalières", Entree::join("elementsentreedates","elementsentreedates.entree_id","entrees.id")
                                                       ->where("annee_id",session("Annee_id")?? 1)
                                                       ->whereRaw("Date(entrees.created_at)=DATE(now())")->count())
            ->description("Nombre d'entrées de la journée")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-shopping-cart"),
            Stat::make("Sorties Journalières", Sortie::join("elementssorties","elementssorties.sortie_id","sorties.id")
                                                        ->where("annee_id",session("Annee_id")?? 1)
                                                        ->whereRaw("Date(sorties.created_at)=DATE(now())")->count())
            ->description("Nombre de Sorties de la journée")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-truck"),
            Stat::make("Produits Critiques", Produit::where("qte","<",100)->count())
            ->description("Nombre de Produit en rupture de stock")
            ->color("danger")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-shopping-bag"),
            Stat::make("Chiffre d'affaire journalier",Sortie::join("elementssorties","elementssorties.sortie_id","sorties.id")
                                                                ->where("annee_id",session("Annee_id")?? 1)
                                                                ->whereRaw("Date(sorties.created_at)=DATE(now())")
                                                                ->SUM("total")." FC")
            ->description("Chiffre d'affaires journalière")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-banknotes"),
            Stat::make("Production journalière",Production::where("annee_id",session("Annee_id")?? 1)
                                                ->whereRaw("Date(productions.created_at)=DATE(now())")->count())
            ->description("Produits concernés par la production")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-archive-box"),
            Stat::make("Matières Premières Critiques", Elementsentree::where("qte","<",50)->count())
            ->description("Matières Premières en rupture de stock")
            ->color("danger")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-shopping-cart"),
        ];
    }

    public function getColumns(): int
    {
        return 3;
    }
}
