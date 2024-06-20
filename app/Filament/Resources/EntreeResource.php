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
use App\Models\Elementsentree;
use Filament\Resources\Resource;
use App\Models\Elementsentreedate;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
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
    protected static ?string $navigationGroup ="Mouvements";
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
                                    ->afterStateUpdated(function($state){
                                        if(session("departement_id") == null){
                                            session()->push("departement_id",$state);
                                        }else{
                                            session()->pull("departement_id");
                                            session()->push("departement_id",$state);
                                        }
                                    })
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
                                        ->live()
                                        ->afterStateUpdated(function($state){
                                            if(session("fournisseur_id") == null){
                                                session()->push("fournisseur_id",$state);
                                            }else{
                                                session()->pull("fournisseur_id");
                                                session()->push("fournisseur_id",$state);
                                            }
                                        })
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
                                    ->live()
                                    ->afterStateUpdated(function($state){
                                        if(session("produit_id") == null){
                                            session()->push("produit_id",$state);
                                        }else{
                                            session()->pull("produit_id");
                                            session()->push("produit_id",$state);
                                        }
                                    })
                                    ->required(),

                        Repeater::make("elementsentrees")
                        ->label("Eléments d'entrée")
                        ->relationship()
                        ->schema([


                                TextInput::make('lib')
                                        ->label("Désignation de la matière Première")
                                        ->required()
                                        ->datalist(Elementsentree::all()->pluck("lib","lib"))
                                        ->placeholder("Ex: Orange"),
                                TextInput::make('qte')
                                        ->label("Quantité")
                                        ->required()
                                        ->placeholder("Ex: 25")
                                        ->numeric(),
                                  TextInput::make('prix')
                                        ->label("Prix Unitaire")
                                        ->required()
                                        ->placeholder("EX: 500")
                                        ->suffix(" FC")
                                        ->numeric(),
                        ])->mutateRelationshipDataBeforeCreateUsing(function (array $data): array|null {


                            //identification de l'entrée en cours
                            $Entree=Entree::whereDepartement_id(session("departement_id"))
                                            ->whereFournisseur_id(session("fournisseur_id"))
                                            ->whereProduit_id(session("produit_id"))
                                            ->first();

                            $data["entree_id"]=$Entree->id;

                            //enregistrement des éléments d'entrées dans la table elementsentreedates
                            Elementsentreedate::create([
                                "entree_id" => $data["entree_id"],
                                "lib"=>$data["lib"],
                                "qte"=>$data["qte"],
                                "prix"=>$data["prix"],
                            ]);
                            //mise à jour de la table elementsentree si elle existe déjà
                            $Eentree=Elementsentree::whereLib($data["lib"])->exists();
                            //si l'éléments entrée n'existe pas
                            if($Eentree==false){

                                return $data;
                            }else{//s'il existe
                                $Ee=Elementsentree::whereLib($data["lib"])->first();
                                $SommeQte=$Ee->qte +=$data["qte"];

                                Elementsentree::whereLib($data["lib"])
                                              ->update([
                                                    "qte"=> $SommeQte,
                                              ]);
                                return null;
                            }




                        })
                        ->columnSpanFull()->columns(3),

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
            ])->defaultSort('created_at', 'desc')
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
