<?php

namespace App\Filament\Resources\VendeurResource\Pages;

use App\Filament\Resources\VendeurResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVendeur extends CreateRecord
{
    protected static string $resource = VendeurResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Vendeur ajouté avec succès!";
    }
}
