<?php

namespace App\Filament\Resources\PresenceResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use Filament\Forms\Set;
use App\Models\Presence;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PresenceResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListPresences extends ListRecords
{
    protected static string $resource = PresenceResource::class;
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
                    return redirect()->route("filament.admin.resources.presences.index");

                });

    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter une présence")
            ->icon("heroicon-o-calendar-days"),
        ];
    }

    public function getTabs():array
    {
        $Annee=Annee::where("id",session("Annee_id") ?? 1)->first();
        return [
            'Aujourd_hui'=>Tab::make()
            ->modifyQueryUsing(function(Builder $query)
            {
               $query->whereRaw("Date(presences.created_at)=DATE(now())");

            })->badge(Presence::query()
            ->whereRaw("Date(created_at)=DATE(now())")->count())
            ->icon("heroicon-o-users"),
            "$Annee->lib"=>Tab::make()
            ->modifyQueryUsing(function(Builder $query)
            {
            $query->where("annee_id",session("Annee_id") ?? 1);

            })->badge(Presence::query()
            ->where("annee_id",session("Annee_id") ?? 1)->count())
            ->icon("heroicon-o-calendar-days"),
            'Toutes'=>Tab::make()
            ->badge(Presence::query()->count()),

        ];
    }
}
