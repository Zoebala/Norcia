<?php

namespace App\Filament\Resources\PointventeResource\Pages;

use App\Filament\Resources\PointventeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPointvente extends EditRecord
{
    protected static string $resource = PointventeResource::class;

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
