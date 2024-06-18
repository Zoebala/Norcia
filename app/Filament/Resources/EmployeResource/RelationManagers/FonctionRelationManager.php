<?php

namespace App\Filament\Resources\EmployeResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class FonctionRelationManager extends RelationManager
{
    protected static string $relationship = 'fonction';
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
                    ->label("Désignation de la fonction")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label("Description")
                    ->sortable()
                    ->placeholder("Pas de description")
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Créée le")
                    ->dateTime('d/m/Y à H:i:s')
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
                Tables\Actions\AttachAction::make()
                ->label("Association Employé-Fonction")
                ->icon("heroicon-o-link"),
            ])
            ->actions([
                ActionGroup::make([

                    Tables\Actions\DetachAction::make(),
                ])->label("Action")->button()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
