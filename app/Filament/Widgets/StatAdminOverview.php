<?php

namespace App\Filament\Widgets;

use App\Models\Entree;
use App\Models\Sortie;
use App\Models\Employe;
use App\Models\Produit;
use App\Models\Vendeur;
use App\Models\Commande;
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
            Stat::make("Présence Journalière", Presence::where("annee_id",session("Annee_id")?? 1)
            ->where("BtnArrivee",1)
            ->whereRaw("Date(presences.created_at)=DATE(now())")->count())
            ->description("Nombre d'employés présent")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-calendar-days"),
            Stat::make("Vendeurs stock Critique", Vendeur::join("stocks","stocks.vendeur_id","vendeurs.id")
                                                ->join("elementsstocks","elementsstocks.stock_id","stocks.id")
                                                ->where("qte","<",10)
                                                 ->where("annee_id",session("Annee_id")??1)->count())
            ->description("Stock produit inférieur à 10 ")
            ->color("danger")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-home-modern"),
            Stat::make("Commande Journalière", Commande::where("annee_id",session("Annee_id")??1)
                                             ->whereRaw("Date(commandes.created_at)=DATE(now())")->count())
            ->description("Les commandes de clients")
            ->color("danger")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-rectangle-stack"),
            Stat::make("Entrées Journalières", Entree::where("annee_id",session("Annee_id")?? 1)
                                                       ->whereRaw("Date(entrees.created_at)=DATE(now())")->count())
            ->description("Nombre d'entrées de la journée")
            ->color("success")
            ->chart([34,2,5,23])
            ->Icon("heroicon-o-shopping-cart"),
            Stat::make("Sorties Journalières", Sortie::where("annee_id",session("Annee_id")?? 1)
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
            Stat::make("Chiffre d'affaires journalières",Sortie::join("elementssorties","elementssorties.sortie_id","sorties.id")
                                                                ->where("annee_id",session("Annee_id")?? 1)
                                                                ->whereRaw("Date(sorties.created_at)=DATE(now())")
                                                                ->SUM("total")." FC")
            ->description("Chiffre d'affaires journalières")
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
