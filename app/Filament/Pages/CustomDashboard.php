<?php

namespace App\Filament\Pages;

use App\Models\Annee;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class CustomDashboard extends Dashboard
{

    use HasFiltersForm;


    protected function getHeaderActions():array
    {
        return [
            Action::make("Accueil")
            ->icon("heroicon-o-home")
            ->action(function(){
                return redirect("/");
            }),
            Action::make("annee_choix")
            ->icon("heroicon-o-calendar")
            // ->visible(fn():bool => session("Annee_id")==null)
            ->slideOver()
            ->label("Choix année de travail")
            ->form([
                Select::make("annee")
                ->label("Choix de l'année")
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(function($state,Set $set){
                    if($state){

                        $Annee=Annee::whereId($state)->get(["lib"]);
                        $set("lib_annee",$Annee[0]->lib);
                    }
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
                    session()->push("Annee_id", $data["annee"]);
                    session()->push("Annee", $data["lib_annee"]);
                }

                // dd(session('Annee'));
                Notification::make()
                ->title("Fixation de l'annee de travail en ".$data['lib_annee'])
                ->success()
                 ->duration(5000)
                ->send();


                return redirect("/admin");


            }),

        ];
    }
    public $defaultAction="annee";

    public function annee():Action
    {
        return Action::make("annee")
        ->icon("heroicon-o-calendar")
        ->visible(fn():bool => session("Annee_id")==null)
        ->slideOver()
        ->label("Choix année de travail")
        ->form([
            Select::make("annee")
            ->label("Choix de l'année")
            ->searchable()
            ->required()
            ->live()
            ->afterStateUpdated(function($state,Set $set){
                if($state){

                    $Annee=Annee::whereId($state)->get(["lib"]);
                    $set("lib_annee",$Annee[0]->lib);
                }
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
                session()->push("Annee_id", $data["annee"]);
                session()->push("Annee", $data["lib_annee"]);
            }

            // dd(session('Annee'));
            Notification::make()
            ->title("Fixation de l'annee de travail en ".$data['lib_annee'])
            ->success()
             ->duration(5000)
            ->send();


            return redirect("/admin");


        });

    }


    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->description("Filtrez vos données ici!")
                ->icon("heroicon-m-funnel")
                ->schema([

                        DatePicker::make("debut")
                            ->label("Date Début")
                            ->live()
                            ->afterStateUpdated(function($state, Set $set,Get $get){
                                if($state>$get("fin")){
                                    $set("fin",null);
                                }

                                if($state>today()){
                                    $set("debut",today());

                                    Notification::make()
                                        ->title("la date définie est supérieure à la date d'aujourd'hui")
                                        ->warning()
                                        ->send();
                                }
                            })
                            ->default(today()),
                        DatePicker::make("fin")
                            ->label("Date Fin"),



                ])->columns(2),
        ]);
    }
}