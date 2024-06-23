<?php

namespace App\Filament\Resources\CommandeResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use App\Models\Commande;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CommandeResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListCommandes extends ListRecords
{
    protected static string $resource = CommandeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter une Commande")
            ->icon("heroicon-o-rectangle-stack"),
        ];
    }

    public function getTabs():array
    {

        $Annee=Annee::where("id",session("Annee_id") ?? 1)->first();


            return [
                'Aujourd_hui'=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                   $query->whereRaw("Date(commandes.created_at)=DATE(now())");

                })->badge(Commande::query()
                ->whereRaw("Date(commandes.created_at)=DATE(now())")->count())
                ->icon("heroicon-o-users"),
                "$Annee->lib"=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                $query->where("annee_id",session("Annee_id") ?? 1);

                })->badge(Commande::query()
                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Toutes'=>Tab::make()
                ->badge(Commande::query()->count()),

            ];

    }
}
