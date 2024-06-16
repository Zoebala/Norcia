<?php

namespace App\Filament\Resources\PointventeResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use App\Models\Pointvente;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;
use App\Filament\Resources\PointventeResource;

class ListPointventes extends ListRecords
{
    protected static string $resource = PointventeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter un point de vente")
            ->icon("heroicon-o-home-modern"),
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

                })->badge(Pointvente::query()
                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Tous'=>Tab::make()
                ->badge(Pointvente::query()->count()),

            ];

    }
}
