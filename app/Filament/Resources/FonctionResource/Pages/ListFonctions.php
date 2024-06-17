<?php

namespace App\Filament\Resources\FonctionResource\Pages;

use App\Filament\Resources\FonctionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFonctions extends ListRecords
{
    protected static string $resource = FonctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter une fonction")
            ->icon("heroicon-o-briefcase"),
        ];
    }
}
