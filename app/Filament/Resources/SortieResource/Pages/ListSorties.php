<?php

namespace App\Filament\Resources\SortieResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use App\Models\Sortie;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SortieResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListSorties extends ListRecords
{
    protected static string $resource = SortieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Effectuer une Sortie/vente")
            ->icon("heroicon-o-truck"),
        ];
    }

    public function getTabs():array
    {

        $Annee=Annee::where("id",session("Annee_id") ?? 1)->first();


            return [
                'Aujourd_hui'=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                   $query->whereRaw("Date(sorties.created_at)=DATE(now())");

                })->badge(Sortie::query()
                 ->join("elementssorties","elementssorties.sortie_id","sorties.id")
                ->whereRaw("Date(sorties.created_at)=DATE(now())")->count())
                ->icon("heroicon-o-users"),
                "$Annee->lib"=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                $query->where("annee_id",session("Annee_id") ?? 1);

                })->badge(Sortie::query()
                ->join("elementssorties","elementssorties.sortie_id","sorties.id")
                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Toutes'=>Tab::make()
                ->badge(Sortie::query()->join("elementssorties","elementssorties.sortie_id","sorties.id")->count()),

            ];

    }
}
