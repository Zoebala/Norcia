<?php

namespace App\Filament\Resources\EmployeResource\Pages;

use App\Models\Annee;
use Filament\Actions;
use App\Models\Employe;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeResource;
use Filament\Resources\Pages\ListRecords\Tab;

class ListEmployes extends ListRecords
{
    protected static string $resource = EmployeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter Employé(e)")
            ->icon("heroicon-o-user-plus"),
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

                })->badge(Employe::query()
                ->where("annee_id",session("Annee_id") ?? 1)->count())
                ->icon("heroicon-o-calendar-days"),
                'Tous'=>Tab::make()
                ->badge(Employe::query()->count()),

            ];

    }
}
