<?php

namespace App\Filament\Resources\VendeurResource\Pages;

use App\Filament\Resources\VendeurResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVendeur extends EditRecord
{
    protected static string $resource = VendeurResource::class;

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
