<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use App\Models\Production;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;
use App\Filament\Resources\ProductionResource;

class ListProductions extends ListRecords
{
    protected static string $resource = ProductionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Effectuer une production")
            ->icon("heroicon-o-archive-box"),
        ];
    }

    public function getTabs():array
    {

        $Annee=Annee::where("id",session("Annee_id") ?? 1)->first();


            return [
                'Aujourd_hui'=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                   $query->whereRaw("Date(productions.created_at)=DATE(now())");

                })->badge(Production::query()
                ->whereRaw("Date(productions.created_at)=DATE(now())")->count())
                ->icon("heroicon-o-users"),
                "$Annee->lib"=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                $query->where("annee_id",session("Annee_id") ?? 1);

                })->badge(Production::query()

                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Toutes'=>Tab::make()
                ->badge(Production::query()->count()),

            ];

    }
}
