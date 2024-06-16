<?php

namespace App\Filament\Resources\DepartementResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PointventesRelationManager extends RelationManager
{
    protected static string $relationship = 'pointventes';
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
                TextColumn::make("annee.lib")
                ->label("Annee")
                ->searchable()
                ->sortable(),
                TextColumn::make("lib")
                ->label("Point de Vente")
                ->searchable()
                ->sortable(),
                TextColumn::make("tel")
                ->label("Téléphone")
                ->searchable()
                ->sortable(),
                TextColumn::make("adresse")
                ->label("Adresse")
                ->searchable()
                ->sortable(),
                TextColumn::make("created_at")
                ->label("Créé le ")
                ->dateTime("d/m/Y à H:i:s")
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                ->label("Association Département-Point de ventes")
                ->icon("heroicon-o-link"),
            ])
            ->actions([
                ActionGroup::make([

                    // Tables\Actions\EditAction::make(),
                    Tables\Actions\DetachAction::make(),
                ])->button()->label("Action"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
