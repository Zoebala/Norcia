<?php

namespace App\Filament\Resources\EntreeResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use App\Models\Entree;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EntreeResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListEntrees extends ListRecords
{
    protected static string $resource = EntreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter une entrée")
            ->icon("heroicon-o-shopping-cart"),
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

                })->badge(Entree::query()
                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Tous'=>Tab::make()
                ->badge(Entree::query()->count()),

            ];

    }
}
