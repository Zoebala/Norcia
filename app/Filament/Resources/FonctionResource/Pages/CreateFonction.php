<?php

namespace App\Filament\Resources\FonctionResource\Pages;

use App\Filament\Resources\FonctionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFonction extends CreateRecord
{
    protected static string $resource = FonctionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Fonction ajoutée avec succès!";
    }
}
