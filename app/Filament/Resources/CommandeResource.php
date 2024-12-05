<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Client;
use App\Models\Produit;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Commande;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departement;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CommandeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CommandeResource\RelationManagers;

class CommandeResource extends Resource
{
    protected static ?string $model = Commande::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 90;
    public static function getNavigationBadge():string
    {
        return static::getModel()::where("annee_id",session("Annee_id")?? 1)
                                  ->whereRaw("Date(created_at)=DATE(now())")->count();
    }
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }

    public static function canAccess(): bool
    {
        if(self::canViewAny()){
            return Annee::isActive();
        }
        return false;
    }

    public static function canViewAny(): bool
    {
        return static::can('viewAny');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Ajouter une commande")
                ->icon("heroicon-o-rectangle-stack")
                ->schema([

                    Select::make('annee_id')
                        ->label("Année")
                        ->options(Annee::whereId(session("Annee_id")??1)->pluck("lib","id"))
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function($state,Set $set){
                            if($state==null)
                                $set("departement_id",null);
                        })
                        ->searchable()
                        ->required(),
                    Select::make('client_id')
                            ->label("Client")
                            ->options(Client::all()->pluck("nom","id"))
                            ->preload()
                            ->searchable()
                            ->required(),
                    Repeater::make("elementscommande")
                    ->label("élément commande")
                    ->relationship()
                    ->schema([

                        Select::make('produit_id')
                            ->label("Produit")
                            ->options(function(Get $get){
                                return Produit::whereActif(1)
                                              ->pluck("lib","id");
                            })
                            ->preload()
                            ->searchable()
                            ->required(),
                        TextInput::make('qte')
                            ->label("Quantité")
                            ->required()
                            ->placeholder("Ex: 45")
                            ->live()
                            ->afterStateUpdated(function(Get $get, Set $set, $state){

                                $Produit=Produit::find($get("produit_id"));
                                $set("total",$state * $Produit->prix);

                            })
                            ->placeholder("Ex: 10"),
                        TextInput::make("total")
                            ->disabled()
                            ->required()
                            ->dehydrated()
                            // ->live()
                            ->suffix(" FC"),
                    ])->columnSpanFull()->columns(3),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                SelectColumn::make('etat')
                ->label("Etat de commande")
                ->options([
                    "Active"=>"Active",
                    "En cours de traitement"=>"En cours de traitement",
                    "En cours de livraison"=>"En cours de livraison",
                    "Livrée"=>"Livrée",
                ])
                ->default("Active")
                ->searchable(),
                TextColumn::make('client.nom')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label("Enregistrée le")
                    ->dateTime("d/m/Y à H:i:s")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
            'index' => Pages\ListCommandes::route('/'),
            'create' => Pages\CreateCommande::route('/create'),
            'edit' => Pages\EditCommande::route('/{record}/edit'),
        ];
    }
}
