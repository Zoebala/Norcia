<?php

namespace App\Filament\Resources\EntreeResource\Pages;

use Filament\Actions;
use App\Models\Entree;
use App\Filament\Resources\EntreeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEntree extends CreateRecord
{
    protected static string $resource = EntreeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Entrée effectuée avec succès!";
    }

}
