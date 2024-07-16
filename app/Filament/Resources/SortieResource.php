<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Sortie;
use App\Models\Produit;
use App\Models\Vendeur;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departement;
use App\Models\Elementsstock;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SortieResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SortieResource\RelationManagers;
use App\Filament\Resources\SortieResource\RelationManagers\ElementssortieRelationManager;

class SortieResource extends Resource
{
    protected static ?string $model = Sortie::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Sorties/Ventes Produits';
    protected static ?string $navigationGroup ="Mouvements";
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }
    public static function getNavigationBadge():string
    {
        return static::getModel()::join("elementssorties","elementssorties.sortie_id","sorties.id")
                                  ->where("annee_id",session("Annee_id")?? 1)
                                  ->whereRaw("Date(sorties.created_at)=DATE(now())")->count();
    }
    protected static ?int $navigationSort = 80;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make("Effectuer une sortie")
                ->icon("heroicon-o-truck")
                ->schema([

                    Forms\Components\Select::make('annee_id')
                        ->label("Année")
                        ->options(Annee::whereId(session("Annee_id")?? 1)->pluck("lib","id"))
                        ->preload()
                        ->live()
                        ->searchable()
                        ->required(),
                    Forms\Components\Select::make('departement_id')
                        ->label("Département")
                        ->live()
                        ->options(function(Get $get){

                            return Departement::join("avoirs","departements.id","avoirs.departement_id")
                                                ->join("fournisseurs","fournisseurs.id","avoirs.fournisseur_id")
                                                ->whereAnnee_id($get("annee_id"))->whereActif(1)->pluck("departements.lib","departements.id");

                        })
                        ->preload()
                        ->afterStateUpdated(function($state){
                            if(session("departement_id") == null){
                                session()->push("departement_id",$state);
                            }else{
                                session()->pull("departement_id");
                                session()->push("departement_id",$state);
                            }
                        })
                        ->searchable()
                        ->required(),
                    Select::make("vendeur_id")
                        ->label("Vendeur")
                        ->options(Vendeur::all()->pluck("nom","id"))
                        ->preload()
                        ->live()
                        ->afterStateUpdated(function($state,Set $set){
                            if(session("vendeur_id") == null){
                                session()->push("vendeur_id",$state);
                            }else{
                                session()->pull("vendeur_id");
                                session()->push("vendeur_id",$state);
                            }

                        })
                        ->searchable()
                        ->required(),

                    Repeater::make("elementssortie")
                        ->label("Elements Sortie")
                        ->relationship()
                        ->schema([
                            TextInput::make("etat")
                            ->label(function(Get $get){
                                return "Etat en Stock";
                            })
                            ->placeholder(function(Get $get, Set $set){

                                $chaine="";
                                if(session("departement_id") !=null && filled($get('produit_id'))){

                                    $Produit=Produit::find($get('produit_id'));
                                    $ProduitVendeur=Elementsstock::whereVendeur_id(session("vendeur_id"))
                                                            ->whereProduit_id($get('produit_id'))
                                                            ->first();


                                    if(!$get("qte")){
                                        if($ProduitVendeur==null){
                                            $chaine="Veuillez choisir un vendeur s'il vous plait";
                                            $set("produit_id",null);
                                            $set("qte",null);
                                            return $chaine;
                                        }
                                        else
                                          $chaine="Nom du Produit : $Produit->lib  |   Quantité en Stock : $ProduitVendeur->qte | Valeur en Stock : ".$ProduitVendeur->qte*$Produit->prix." FC";

                                    }else{
                                        if($ProduitVendeur==null){
                                            $chaine="Veuillez choisir un vendeur s'il vous plait";
                                            $set("produit_id",null);
                                            $set("qte",null);
                                            return $chaine;
                                        }
                                        $PQ=(int)$ProduitVendeur->qte;
                                        $Qte=(int)$get("qte");
                                        $Reste=$PQ-$Qte;

                                        $chaine="Nom du Produit : $Produit->lib  |   Quantité en Stock : $ProduitVendeur->qte | Valeur en Stock : ".$ProduitVendeur->qte*$Produit->prix." FC | Reste : ".$Reste." | Valeur Restante ".$Produit->prix*$Reste." FC";

                                    }

                                    return $chaine;
                                }



                            })->visibleOn("create")
                            ->hidden(function(Get $get){
                                if(session("departement_id") !=null && filled($get('produit_id'))){
                                    return false;
                                }else{
                                    return true;
                                }
                            })
                            ->disabled()
                            ->columnSpanFull(),
                            Select::make("produit_id")
                                ->label("Produit")
                                ->live()
                                ->options(function(Get $get){
                                    return Produit::join("elementsstocks","elementsstocks.produit_id","produits.id")
                                                    ->whereDepartement_id(session("departement_id"))
                                                    ->whereVendeur_id(session("vendeur_id"))
                                                    ->pluck("produits.lib","produits.id");
                                })->preload()
                                ->searchable()
                                ->afterStateUpdated(function(Set $set){
                                    $set("qte",null);
                                })
                                ->required(),
                            TextInput::make("qte")
                                ->label("Quantié")
                                ->numeric()
                                ->required()
                                ->live()
                                ->disabled(fn(Get $get):bool=> !filled($get("produit_id")))
                                ->afterStateUpdated(function(Get $get, Set $set, $state){

                                    $Produit=Produit::find($get("produit_id"));
                                    $ProduitVendeur=Elementsstock::whereVendeur_id(session("vendeur_id"))
                                                            ->whereProduit_id($get('produit_id'))
                                                            ->first();

                                    // $set("Total",$state * $Produit->prix);
                                    $set("total",$state * $Produit->prix);
                                    if($state>$ProduitVendeur->qte){
                                        $set("qte",null);
                                        Notification::make()
                                                    ->title("La quantité saisie est supérieure à la quantité en stock")
                                                    ->warning()
                                                    ->send();
                                    }



                                })
                                ->placeholder("Ex: 10"),
                            TextInput::make("total")
                                ->disabled()
                                ->required()
                                ->dehydrated()
                                // ->live()
                                ->suffix(" FC"),



                       ])->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {

                            //identificaton du stock vendeur réalisant la sortie/vente
                            $ProduitVendeur=Elementsstock::whereVendeur_id(session("vendeur_id"))
                                                            ->whereProduit_id($data['produit_id'])
                                                            ->first();
                            //Dimunition en stock vendeur sorti
                            Elementsstock::whereVendeur_id(session("vendeur_id"))
                                         ->whereId($data['produit_id'])
                                         ->update([
                                            'qte'=>$ProduitVendeur->qte-$data["qte"],
                                         ]);

                            //enregistrement de l'opération de sortie
                            return $data;
                    })->columnSpanFull()
                    ->columns(3),
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('departement.lib')
                    ->label("Département")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('vendeur.nom')
                    ->label("Vendeur")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Enregistrée le")
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
            ElementssortieRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSorties::route('/'),
            'create' => Pages\CreateSortie::route('/create'),
            'edit' => Pages\EditSortie::route('/{record}/edit'),
        ];
    }
}
