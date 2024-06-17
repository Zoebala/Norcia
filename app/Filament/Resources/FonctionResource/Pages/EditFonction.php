<?php

namespace App\Filament\Resources\FonctionResource\Pages;

use App\Filament\Resources\FonctionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFonction extends EditRecord
{
    protected static string $resource = FonctionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];

    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
