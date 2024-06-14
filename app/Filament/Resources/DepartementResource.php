<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departement;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DepartementResource\Pages;
use App\Filament\Resources\DepartementResource\RelationManagers;

class DepartementResource extends Resource
{
    protected static ?string $model = Departement::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 2;
    public static function getNavigationBadge():string
    {
        return static::getModel()::where("annee_id",session("Annee_id")??1)->count();
    }
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //

                    Wizard::make([
                        Step::make("Informations")
                        ->schema([
                            Select::make("annee_id")
                            ->label("Année")
                            ->required()
                            ->options(function(){

                                    return Annee::where("id",session("Annee_id")??1)->pluck('lib','id');

                            })->searchable()
                            ->preload()
                            ->columnSpan(1),
                            TextInput::make('lib')
                                ->label("Departement")
                                ->unique(ignoreRecord:true,table: Departement::class)
                                ->required()
                                ->placeholder("Ex: Informatique")
                                ->maxLength(255)
                                ->columnSpan(1),

                        ]),
                        Step::make("Description")
                        ->schema([
                            MarkdownEditor::make('description')->columnSpanFull(),
                        ])
                    ])->columns(2)->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            ->actions([
                ActionGroup::make([

                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->button()->label("Actions"),
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
            'index' => Pages\ListDepartements::route('/'),
            'create' => Pages\CreateDepartement::route('/create'),
            'edit' => Pages\EditDepartement::route('/{record}/edit'),
        ];
    }
}
