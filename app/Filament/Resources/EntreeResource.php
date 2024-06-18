<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Entree;
use App\Models\Produit;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departement;
use App\Models\Fournisseur;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EntreeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EntreeResource\RelationManagers;
use App\Filament\Resources\EntreeResource\RelationManagers\ElementsentreesRelationManager;

class EntreeResource extends Resource
{
    protected static ?string $model = Entree::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Entrées/M.Premières';
    protected static ?string $navigationGroup ="NB Management";
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }
    public static function getNavigationBadge():string
    {
        return static::getModel()::join("elementsentrees","elementsentrees.entree_id","entrees.id")
                                  ->where("annee_id",session("Annee_id")?? 1)
                                  ->whereRaw("Date(entrees.created_at)=DATE(now())")->count();
    }
    protected static ?int $navigationSort = 60;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                    Section::make("Ajout Entrée")
                    ->icon("heroicon-o-shopping-cart")
                    ->schema([
                        Forms\Components\Select::make('annee_id')
                                ->label("Année")
                                ->required()
                                ->options(Annee::whereId(session("Annee_id") ??1)->pluck("lib","id"))
                                ->preload()
                                ->searchable()
                                ->live(),
                        Forms\Components\Select::make('departement_id')
                                    ->label("Departement")
                                    ->options(function(Get $get){
                                        return Departement::where("annee_id",$get("annee_id"))->pluck("lib","id");
                                    })
                                    ->preload()
                                    ->searchable()
                                    ->live()
                                    ->required(),
                        Forms\Components\Select::make('fournisseur_id')
                                        ->label("Fournisseur")
                                        ->options(function(Get $get){
                                            return Fournisseur::join("avoirs","avoirs.fournisseur_id","fournisseurs.id")
                                                            ->join("departements","avoirs.departement_id","departements.id")
                                                            ->where("avoirs.departement_id",$get("departement_id"))
                                                            ->where("departements.annee_id",session("Annee_id")??1)
                                                            ->where("departements.actif",1)
                                                            ->pluck("fournisseurs.nom","fournisseurs.id");
                                        })
                                        ->preload()
                                        ->live()
                                        ->searchable()
                                        ->required(),
                        Forms\Components\Select::make('produit_id')
                                    ->label("Produit")
                                    ->options(function(Get $get){
                                        return Produit::where("departement_id",$get("departement_id"))
                                                        ->where("annee_id",$get("annee_id"))
                                                        ->whereActif(1)
                                                        ->pluck("lib","id");
                                    })->preload()
                                    ->searchable()
                                    ->required(),

                        Repeater::make("elementsentrees")
                        ->label("Eléments d'entrée")
                        ->relationship()
                        ->schema([


                                     Forms\Components\TextInput::make('lib')
                                                        ->label("Désignation de la matière Première")
                                                        ->required()
                                                        ->placeholder("Ex: Orange"),
                                    Forms\Components\TextInput::make('qte')
                                                        ->label("Quantité")
                                                        ->required()
                                                        ->placeholder("Ex: 25")
                                                        ->numeric(),
                                    Forms\Components\TextInput::make('prix')
                                                        ->label("Prix Unitaire")
                                                        ->required()
                                                        ->placeholder("EX: 500")
                                                        ->suffix(" FC")
                                                        ->numeric(),
                        ])->columnSpanFull()->columns(3)
                    ])->columns(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('annee.lib')
                    ->label("Année")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('departement.lib')
                        ->label("Departement")
                        ->searchable()
                        ->sortable(),
                Tables\Columns\TextColumn::make('fournisseur.nom')
                            ->label("Fournisseur")
                            ->searchable()
                            ->sortable(),
                Tables\Columns\TextColumn::make('produit.lib')
                            ->label("Produit")
                            ->searchable()
                            ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label("Enregistrée le ")
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

            ElementsentreesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEntrees::route('/'),
            'create' => Pages\CreateEntree::route('/create'),
            'edit' => Pages\EditEntree::route('/{record}/edit'),
        ];
    }
}
