<?php

namespace App\Filament\Resources\PointventeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class DepartementsRelationManager extends RelationManager
{
    protected static string $relationship = 'departements';
    protected static bool $isLazy = false;
    protected bool | Closure $isRecordSelectPreloaded = true;

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
                TextColumn::make('annee.lib')
                ->label("Année")
                ->searchable()
                ->sortable(),
                TextColumn::make('lib')
                ->label("Departement")
                ->searchable()
                ->sortable(),
                TextColumn::make('description')
                    ->label("Description")
                    ->searchable()
                    ->placeholder("Pas de description"),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                ->label("Association Point de Vente-Départements")
                ->icon("heroicon-o-link"),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                ActionGroup::make([

                    Tables\Actions\DetachAction::make(),
                ])->button()->label("Action")
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
