<?php

namespace App\Filament\Resources\PointventeResource\Pages;

use App\Filament\Resources\PointventeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePointvente extends CreateRecord
{
    protected static string $resource = PointventeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Point de vente ajouté avec succès!";
    }
}
