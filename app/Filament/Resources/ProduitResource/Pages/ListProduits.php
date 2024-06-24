<?php

namespace App\Filament\Resources\ProduitResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use App\Models\Produit;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProduitResource;
use Filament\Resources\Pages\ListRecords\Tab;
use App\Filament\Resources\ProduitResource\Widgets\Produitchart;
use App\Filament\Resources\ProduitResource\Widgets\StatProduitAdmin;
use App\Filament\Resources\ProduitResource\Widgets\Produitvenduschart;
use App\Filament\Resources\ProduitResource\Widgets\Caffaireproduitchart;
use App\Filament\Resources\ProduitResource\Widgets\CaffaireProduitsvendus;

class ListProduits extends ListRecords
{
    protected static string $resource = ProduitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter un produit")
            ->icon("heroicon-o-shopping-bag"),
        ];
    }

    public function getTabs():array
    {

        $Annee=Annee::where("id",session("Annee_id") ?? 1)->first();


            return [
                "$Annee->lib"=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                $query->where("annee_id",session("Annee_id") ?? 1);

                })->badge(Produit::query()
                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Tous'=>Tab::make()
                ->badge(Produit::query()->count()),

            ];

    }


    protected function getFooterWidgets(): array
    {
        return [
            StatProduitAdmin::class,
            Produitvenduschart::class,
            CaffaireProduitsvendus::class,
            Produitchart::class,
            Caffaireproduitchart::class,

        ];
    }

    protected function getWidgets():array
    {
        return [
            StatProduitAdmin::class,
            Produitchart::class,
            Caffaireproduitchart::class,
        ];
    }
}
