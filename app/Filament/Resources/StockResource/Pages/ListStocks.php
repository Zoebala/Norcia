<?php

namespace App\Filament\Resources\StockResource\Pages;

use App\Models\Annee;
use App\Models\Stock;
use Filament\Actions;
use App\Models\Vendeur;
use Filament\Forms\Set;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use App\Filament\Resources\StockResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;

class ListStocks extends ListRecords
{
    protected static string $resource = StockResource::class;
    public $defaultAction="Annee";

    public function Annee():Action
    {
        return Action::make("Annee")
                ->modalHeading("Définition de l'année de travail")
                ->visible(fn():bool => session('Annee_id')==NULL)
                ->form([
                    Select::make("annee")
                    ->label("Choix de l'année")
                    ->searchable()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function($state,Set $set){
                        $Annee=Annee::whereId($state)->get(["lib"]);
                        $set("lib_annee",$Annee[0]->lib);



                    })
                    ->options(Annee::query()->pluck("lib","id")),
                    Hidden::make("lib_annee")
                    ->label("Année Choisie")
                    ->disabled()
                    // ->hidden()
                    ->dehydrated(true)


                ])
                ->modalWidth(MaxWidth::Medium)
                ->modalIcon("heroicon-o-calendar")
                ->action(function(array $data){
                    if(session('Annee_id')==NULL && session('Annee')==NULL){

                        session()->push("Annee_id", $data["annee"]);
                        session()->push("Annee", $data["lib_annee"]);

                    }else{
                        session()->pull("Annee_id");
                        session()->pull("Annee");
                    }

                    // dd(session('Annee'));
                    Notification::make()
                    ->title("Fixation de l'annee de travail en ".$data['lib_annee'])
                    ->success()
                     ->duration(5000)
                    ->send();
                    return redirect()->route("filament.admin.resources.stocks.index");

                });

    }

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

        $Annee=Annee::where("id",session("Annee_id")[0] ?? 1)->first();


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
                $query->where("annee_id",session("Annee_id")[0] ?? 1);

                })->badge(Stock::query()
                ->join("elementsstocks","elementsstocks.stock_id","stocks.id")
                ->where("annee_id",session("Annee_id")[0] ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Toutes'=>Tab::make()
                ->badge(Stock::query()->join("elementsstocks","elementsstocks.stock_id","stocks.id")->count()),
                'Critiques'=>Tab::make()
                ->modifyQueryUsing(function(Builder $query)
                {
                     $query->join("vendeurs","vendeurs.id","stocks.vendeur_id")
                            ->join("elementsstocks","elementsstocks.stock_id","stocks.id")
                            ->where("qte","<",10)
                            ->where("annee_id",session("Annee_id")[0] ?? 1);

                })
                ->badge(Vendeur::join("stocks","stocks.vendeur_id","vendeurs.id")
                ->join("elementsstocks","elementsstocks.stock_id","stocks.id")
                ->where("qte","<",10)
                 ->where("annee_id",session("Annee_id")[0] ?? 1)->count()),

            ];

    }
}
