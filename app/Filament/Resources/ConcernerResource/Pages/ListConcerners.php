<?php

namespace App\Filament\Resources\ConcernerResource\Pages;

use App\Filament\Resources\ConcernerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConcerners extends ListRecords
{
    protected static string $resource = ConcernerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
