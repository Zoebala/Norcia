<?php

namespace App\Filament\Resources\VendeurResource\Pages;

use App\Filament\Resources\VendeurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendeurs extends ListRecords
{
    protected static string $resource = VendeurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Ajouter un vendeur")
            ->icon("heroicon-o-user-plus"),
        ];
    }
}
