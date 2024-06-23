<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Stock;
use App\Models\Employe;
use App\Models\Produit;
use App\Models\Vendeur;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departement;
use App\Models\Elementsstock;
use Filament\Resources\Resource;
use App\Models\Elementsstockdate;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StockResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StockResource\RelationManagers;
use App\Filament\Resources\StockResource\RelationManagers\ElementsstocksRelationManager;
use App\Filament\Resources\StockResource\RelationManagers\ElementsstockdatesRelationManager;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationLabel = 'Stockage/Ravitaillement';
    protected static ?string $modelLabel = 'Stockage/Ravitaillement';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 70;

    public static function getNavigationBadge():string
    {
        return static::getModel()::join("elementsstocks","elementsstocks.stock_id","stocks.id")
        ->where("annee_id",session("Annee_id")?? 1)
        ->whereRaw("Date(stocks.created_at)=DATE(now())")->count();
    }
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Définition des Stock")
                ->icon("heroicon-o-circle-stack")
                ->schema([
                    Select::make('annee_id')
                        ->label("Année")
                        ->options(Annee::whereId(session("Annee_id") ?? 1)->pluck("lib","id"))
                        ->live()
                        ->preload()
                        ->searchable()
                        ->required(),
                    Select::make('departement_id')
                        ->label("Département")
                        ->options(function(Get $get){
                            return Departement::whereAnnee_id($get("annee_id"))
                                              ->whereActif(1)
                                              ->pluck("lib","id");
                        })
                        ->live()
                        ->afterStateUpdated(function($state){
                            if(session("departement_id") == null){
                                session()->push("departement_id",$state);
                            }else{
                                session()->pull("departement_id");
                                session()->push("departement_id",$state);
                            }
                        })
                        ->preload()
                        ->searchable()
                        ->required(),
                    Select::make('vendeur_id')
                        ->label("Vendeur")
                        ->options(Vendeur::all()->pluck("nom","id"))
                        ->live()
                        ->afterStateUpdated(function($state){
                            if(session("vendeur_id") == null){
                                session()->push("vendeur_id",$state);
                            }else{
                                session()->pull("vendeur_id");
                                session()->push("vendeur_id",$state);
                            }
                        })
                        ->preload()
                        ->searchable()
                        ->required(),
                    Repeater::make("elementsstocks")
                        ->label("élément Stock")
                        ->relationship()
                        ->schema([
                            TextInput::make("etat")
                                ->label(function(Get $get){
                                    return "Etat en Stock";
                                })
                                ->placeholder(function(Get $get){

                                    $chaine="";
                                    if(session("departement_id") !=null && filled($get('produit_id'))){

                                        $Produit=Produit::find($get('produit_id'));

                                        if(!$get("qte")){
                                            $chaine="Nom du Produit : $Produit->lib  |   Quantité en Stock : $Produit->qte | Valeur en Stock : ".$Produit->prix * $Produit->qte." FC";

                                        }else{
                                            $PQ=(int)$Produit->qte;
                                            $Qte=(int)$get("qte");
                                            $Reste=$PQ-$Qte;
                                            $chaine="Nom du Produit : $Produit->lib  |   Quantité en Stock : $Produit->qte | Valeur en Stock : ".$Produit->prix * $Produit->qte." FC | Reste : ".$Reste." | Valeur Restante ".$Produit->prix*$Reste." FC";
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
                                ->required()
                                ->live()
                                ->options(function(){
                                    return Produit::whereDepartement_id(session("departement_id"))->whereActif(1)->pluck("lib","id");
                                })->preload()
                                ->searchable(),
                            TextInput::make("qte")
                                ->label("Quantité")
                                ->numeric()
                                ->placeholder("Ex: 35")
                                ->live()
                                ->afterStateUpdated(function(Get $get, Set $set, $state){

                                    $Produit=Produit::find($get("produit_id"));

                                    // $set("Total",$state * $Produit->prix);
                                    $set("total",$state * $Produit->prix);

                                    if($state>$Produit->qte){

                                        $set("qte",null);

                                        Notification::make()
                                                    ->title("La quantité saisie dépasse la quantité en stock")
                                                    ->warning()
                                                    ->send();
                                    }

                                })
                                ->required(),
                            TextInput::make("total")
                                ->disabled()
                                ->required()
                                ->dehydrated()
                                // ->live()
                                ->suffix(" FC"),
                        ])
                        ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array|null {
                            //identificaton du produit sorti pour stockage vendeur
                            $Produit=Produit::find($data['produit_id']);
                            //Dimunition en stock des produits à destination des vendeurs
                            Produit::whereId($data['produit_id'])
                            ->update([
                                'qte'=>$Produit->qte-$data["qte"],
                            ]);


                            //identification du stock en cours
                            $Stock=Stock::whereDepartement_id(session("departement_id"))
                                            ->whereVendeur_id(session("vendeur_id"))
                                            ->first();

                            $data["stock_id"]=$Stock->id;

                            //enregistrement des éléments de stock dans la table elementsstockdates
                            Elementsstockdate::create([
                                "stock_id" => $data["stock_id"],
                                "produit_id"=>$data["produit_id"],
                                "vendeur_id"=>session("vendeur_id")[0],
                                "qte"=>$data["qte"],
                                "total"=>$data["total"],
                            ]);


                            //mise à jour de la table elementsstock si elle existe déjà
                            $Estock=Elementsstock::whereProduit_id($data["produit_id"])
                                                 ->whereVendeur_id(session("vendeur_id"))
                                                 ->exists();
                            //si l'élément stock n'existe pas
                            if($Estock==false){
                                $data["vendeur_id"]=session("vendeur_id")[0];
                                return $data;
                            }else{//s'il existe
                                $Es=Elementsstock::whereProduit_id($data["produit_id"])
                                                 ->whereVendeur_id(session("vendeur_id"))
                                                 ->first();
                                $SommeQte=$Es->qte +=$data["qte"];

                                Elementsstock::whereProduit_id($data["produit_id"])
                                              ->whereVendeur_id(session("vendeur_id"))
                                              ->update([
                                                    "qte"=> $SommeQte,
                                              ]);
                                return null;
                            }



                            // return $data;
                       })
                        ->columnSpanFull()->columns(3),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('departement.lib')
                    ->label("Département")
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('vendeur.nom')
                    ->label("Vendeur")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Enregistré le")
                    ->dateTime("d/m/Y à H:i:s")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label("Mise à jour le")
                    ->dateTime("d/m/Y à H:i:s")
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

            ElementsstocksRelationManager::class,
            ElementsstockdatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
