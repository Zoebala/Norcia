<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Fournisseur;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FournisseurResource\Pages;
use App\Filament\Resources\FournisseurResource\RelationManagers;

class FournisseurResource extends Resource
{
    protected static ?string $model = Fournisseur::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 28;
    public static function getNavigationBadge():string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Définition d'un fournisseur")
                ->icon("heroicon-o-user-plus")
                ->schema([
                    Forms\Components\TextInput::make('nom')
                        ->required()
                        ->placeholder("Ex: John Dupont")
                        ->maxLength(255),
                    Forms\Components\TextInput::make('adresse')
                        ->required()
                        ->placeholder("Ex : 45, Av. Mweneditu Q/Disengomoka")
                        ->maxLength(255),
                    Forms\Components\TextInput::make('tel')
                        ->tel()
                        ->label("Téléphone")
                        ->required()
                        ->placeholder("Ex: 089XXXXXXX")
                        ->maxLength(10),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->placeholder("Ex: dupont@gmail.com")
                        ->maxLength(50),

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('adresse')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tel')
                    ->searchable()
                    ->label("Téléphone")
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([

                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->button()->label("Actions")
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
            'index' => Pages\ListFournisseurs::route('/'),
            'create' => Pages\CreateFournisseur::route('/create'),
            'edit' => Pages\EditFournisseur::route('/{record}/edit'),
        ];
    }
}
