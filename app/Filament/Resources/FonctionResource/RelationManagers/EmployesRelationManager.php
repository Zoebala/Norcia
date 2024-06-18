<?php

namespace App\Filament\Resources\FonctionResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class EmployesRelationManager extends RelationManager
{
    protected static string $relationship = 'employes';
    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nom')
            ->columns([
                Tables\Columns\TextColumn::make('fonction.lib')
                ->label("Fonction")
                ->placeholder("Pas de Fonction")
                ->searchable()
                ->formatStateUsing(function($state){
                    if(mb_strlen($state)>10)
                        return substr($state,0,12)."...";
                    else
                        return $state;
                })
                ->sortable(),
            Tables\Columns\TextColumn::make('matricule')
                ->label("Matricule")
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('nom')
                ->label("Nom Complet")
                ->getStateUsing(fn($record)=> $record->nom." ".$record->postnom." ".$record->prenom)
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('genre')
                ->label("Genre")
                ->sortable()
                ->searchable(),
            Tables\Columns\ImageColumn::make('photo')
                ->label("Photo")
                ->placeholder("Pas de Profil")
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
            Tables\Columns\ImageColumn::make('elements_dossiers')
                ->label("Mes éléments de dossier")
                ->placeholder("N'a pas d'éléménts dossier")
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
            Tables\Columns\TextColumn::make('province')
                ->label("Province")
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('datenais')
                ->label("Date de naissance")
                ->date("d/m/Y")
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                ->label("Association Fonction-employé")
                ->icon("heroicon-o-link"),
            ])
            ->actions([
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
