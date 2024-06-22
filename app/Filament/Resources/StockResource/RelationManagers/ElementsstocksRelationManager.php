<?php

namespace App\Filament\Resources\StockResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Produit;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ElementsstocksRelationManager extends RelationManager
{
    protected static string $relationship = 'elementsstocks';
    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('produit_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('produit_id')
            ->columns([
                Tables\Columns\TextColumn::make('produit_id')
                ->label("Produit")
                ->getStateUsing(function($record){
                    $Prod=Produit::find($record->produit_id);

                    return $Prod->lib;
                }),
                TextColumn::make("qte")
                ->label("Quantité")
                ->sortable(),
                TextColumn::make("created_at")
                ->label("Enregistré le ")
                ->datetime("d/m/Y à H:i:s")
                ->searchable()
                ->sortable(),

            ])->defaultSort("created_at","desc")
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                ActionGroup::make([

                    Tables\Actions\DeleteAction::make(),
                ])->button()->label("Action")
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
