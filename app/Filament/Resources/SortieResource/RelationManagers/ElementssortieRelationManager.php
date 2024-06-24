<?php

namespace App\Filament\Resources\SortieResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ElementssortieRelationManager extends RelationManager
{
    protected static string $relationship = 'elementssortie';
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
                Tables\Columns\TextColumn::make('produit.lib')
                                         ->label("Produit")
                                         ->searchable()
                                         ->sortable(),
                Tables\Columns\TextColumn::make('qte')
                ->label("Quantité")
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('total')
                ->label("Total")
                ->suffix(" FC")
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Enregistrée le")
                    ->dateTime("d/m/Y à H:i:s")
                    ->sortable()

                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
