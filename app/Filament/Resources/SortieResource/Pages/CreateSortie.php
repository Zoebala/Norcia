<?php

namespace App\Filament\Resources\SortieResource\Pages;

use App\Filament\Resources\SortieResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSortie extends CreateRecord
{
    protected static string $resource = SortieResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Sortie effectuée avec succès!";
    }

    protected function mutateFormDataBeforeCreate(array $data):array
    {

        $data["annee_id"]=(int)session("Annee_id")[0];
        return $data;
    }
}
