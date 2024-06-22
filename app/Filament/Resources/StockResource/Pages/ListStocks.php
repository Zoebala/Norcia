<?php

namespace App\Filament\Resources\StockResource\Pages;

use App\Models\Annee;
use App\Models\Stock;
use Filament\Actions;
use App\Filament\Resources\StockResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;

class ListStocks extends ListRecords
{
    protected static string $resource = StockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter un stock/Ravitaillement")
            ->icon("heroicon-o-circle-stack"),
        ];
    }

    public function getTabs():array
    {

        $Annee=Annee::where("id",session("Annee_id") ?? 1)->first();


            return [
                'Aujourd_hui'=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                   $query->whereRaw("Date(stocks.created_at)=DATE(now())");

                })->badge(Stock::query()
                 ->join("elementsstocks","elementsstocks.stock_id","stocks.id")
                ->whereRaw("Date(stocks.created_at)=DATE(now())")->count())
                ->icon("heroicon-o-users"),
                "$Annee->lib"=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                $query->where("annee_id",session("Annee_id") ?? 1);

                })->badge(Stock::query()
                ->join("elementsstocks","elementsstocks.stock_id","stocks.id")
                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Toutes'=>Tab::make()
                ->badge(Stock::query()->join("elementsstocks","elementsstocks.stock_id","stocks.id")->count()),

            ];

    }
}
