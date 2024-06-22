<?php

namespace App\Filament\Resources\StockResource\Pages;

use App\Filament\Resources\StockResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStock extends CreateRecord
{
    protected static string $resource = StockResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Stockage/Ravitaillement effectué avec succès!";
    }

    // protected function mutateFormDataBeforeCreate(array $data):array
    // {
    //     dd(session("vendeur_id")[0]);
    //     return $data;
    // }
}
