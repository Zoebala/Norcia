<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Concerner;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ConcernerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ConcernerResource\RelationManagers;

class ConcernerResource extends Resource
{
    protected static ?string $model = Concerner::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationLabel = 'Départements-Point de Ventes-Produits';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 50;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make("departement.lib")
                ->label("Département")
                ->searchable()
                ->sortable(),
                TextColumn::make("pointvente.lib")
                ->label("Point de Vente")
                ->searchable()
                ->sortable(),
                TextColumn::make("produit.lib")
                ->label("Produit")
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConcerners::route('/'),
            'create' => Pages\CreateConcerner::route('/create'),
            'edit' => Pages\EditConcerner::route('/{record}/edit'),
        ];
    }
}
