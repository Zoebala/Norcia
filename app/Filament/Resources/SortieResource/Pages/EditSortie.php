<?php

namespace App\Filament\Resources\SortieResource\Pages;

use App\Filament\Resources\SortieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSortie extends EditRecord
{
    protected static string $resource = SortieResource::class;

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
