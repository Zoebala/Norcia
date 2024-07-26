<?php

namespace App\Filament\Resources\DepartementResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use Filament\Forms\Set;
use App\Models\Departement;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords\Tab;
use App\Filament\Resources\DepartementResource;

class ListDepartements extends ListRecords
{
    protected static string $resource = DepartementResource::class;

    public $defaultAction="Annee";

    public function Annee():Action
    {
        return Action::make("Annee")
                ->modalHeading("Définition de l'année de travail")
                ->visible(function(){
                    if(session('Annee_id')==NULL && session('Annee')==NULL){
                        return true;
                    }
                })
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

                });

    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter un Département")
            ->icon("heroicon-o-building-office"),
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

                })->badge(Departement::query()
                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Tous'=>Tab::make()
                ->badge(Departement::query()->count()),

            ];

    }
}
