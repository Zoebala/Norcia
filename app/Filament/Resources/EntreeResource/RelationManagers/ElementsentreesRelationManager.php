<?php

namespace App\Filament\Resources\EntreeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ElementsentreesRelationManager extends RelationManager
{
    protected static string $relationship = 'elementsentrees';
    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('lib')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('lib')
            ->columns([
                Tables\Columns\TextColumn::make('lib')
                ->label("Matière Première")
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('qte')
                ->label("Quantité")
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('prix')
                ->label("Prix Unitaire")
                ->suffix(" FC")
                ->searchable()
                ->sortable(),
            ])
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
