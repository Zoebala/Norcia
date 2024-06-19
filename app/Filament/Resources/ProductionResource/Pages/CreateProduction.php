<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use Filament\Actions;
use App\Models\Produit;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductionResource;

class CreateProduction extends CreateRecord
{
    protected static string $resource = ProductionResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ? string
    {
        return "Production effectuée avec succès!";
    }

    protected function mutateFormDataBeforeCreate(array $data):array
    {

        //Identification du produit concerné par la production
        $Produit=Produit::find($data["produit_id"]);
        //Augmentation en stock des produits concerné par la production
        $Produit->qte +=$data["qte"];
        $Produit->update();

        return $data;
    }
}
