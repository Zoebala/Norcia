<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Produit;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Production;
use Filament\Tables\Table;
use App\Models\Departement;
use App\Models\Elementsentree;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductionResource\Pages;
use App\Filament\Resources\ProductionResource\RelationManagers;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup ="Mouvements";
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }
    public static function getNavigationBadge():string
    {
        return static::getModel()::where("annee_id",session("Annee_id")[0] ?? 1)
                                  ->whereRaw("Date(productions.created_at)=DATE(now())")->count();
    }
    protected static ?int $navigationSort = 70;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Définition de la production")
                ->icon("heroicon-o-archive-box")
                ->schema([
                    TextInput::make("etatproduit")
                            ->label(function(Get $get){
                                return "Etat en Stock";
                            })
                            ->placeholder(function(Get $get){

                                $chaine="";
                                if($get("departement_id") !=null && filled($get('produit_id'))){

                                    $Produit=Produit::find($get('produit_id'));

                                    if(!$get("qte")){
                                        if($Produit==null)
                                            return $chaine;
                                        else
                                            $chaine="Nom du Produit : $Produit->lib  |   Quantité en Stock : $Produit->qte | Valeur en Stock : ".$Produit->prix * $Produit->qte." FC";

                                    }else{
                                        $PQ=(int)$Produit->qte;
                                        $Qte=(int)$get("qte");
                                        $somme=$PQ+$Qte;
                                        $chaine="Nom du Produit : $Produit->lib  |   Quantité en Stock : $Produit->qte | Valeur en Stock : ".$Produit->prix * $Produit->qte." FC | Quantité : ".$somme." | Valeur Restante ".$Produit->prix*$somme." FC";
                                    }

                                    return $chaine;
                                }



                            })->visibleOn("create")
                            ->hidden(function(Get $get){
                                if($get("departement_id") !=null && filled($get('produit_id'))){
                                    return false;
                                }else{
                                    return true;
                                }
                    })->disabled() ->columnSpanFull(),

                    Select::make('departement_id')
                        ->label("Département")
                        ->required()
                        ->live()
                        ->options(function(Get $get){
                            return Departement::join("avoirs","departements.id","avoirs.departement_id")
                                                ->join("fournisseurs","fournisseurs.id","avoirs.fournisseur_id")
                                                ->whereAnnee_id(session("Annee_id")[0] ?? 1)->whereActif(1)->pluck("departements.lib","departements.id");
                        })->preload()
                        ->searchable(),
                    Select::make('produit_id')
                        ->label("Produit")
                        ->required()
                        ->options(function(Get $get){
                            return Produit::whereDepartement_id($get("departement_id"))->whereActif(1)->pluck("lib","id");
                        })->preload()
                        ->live()
                        ->afterStateUpdated(function($state,Set $set){
                            $set("qte",null);
                            if(session("produit_id") == null){
                                session()->push("produit_id",$state);
                            }else{
                                session()->pull("produit_id");
                                session()->push("produit_id",$state);
                            }
                        })
                        ->searchable(),
                    TextInput::make("qte")
                        ->label("Quantité")
                        ->required()
                        ->numeric()
                        ->disabled(fn(Get $get):bool=> !filled($get("produit_id")))
                        ->live()
                        ->afterStateUpdated(function($state){
                            if(session("qte") == null){
                                session()->push("qte",$state);
                            }else{
                                session()->pull("qte");
                                session()->push("qte",$state);
                            }
                        })
                        ->placeholder("Ex: 45"),
                    Repeater::make("elementsproduction")
                        ->label("Element Production")
                        ->relationship()
                        ->schema([
                            TextInput::make("etat")
                            ->label(function(Get $get){
                                return "Etat en Stock";
                            })
                            ->placeholder(function(Get $get){

                                $chaine="";
                                if(filled($get('elementsentree_id'))){

                                    $Eentree=Elementsentree::find($get('elementsentree_id'));

                                    if(!$get("qte")){
                                        $chaine="Matière première : $Eentree->lib  |   Quantité en Stock : $Eentree->qte | Valeur en Stock : ".$Eentree->prix * $Eentree->qte." FC";

                                    }else{
                                        $PQ=(int)$Eentree->qte;
                                        $Qte=(int)$get("qte");
                                        $Reste=$PQ-$Qte;
                                        $chaine="Matière première : $Eentree->lib  |   Quantité en Stock : $Eentree->qte | Valeur en Stock : ".$Eentree->prix * $Eentree->qte." FC | Reste : ".$Reste." | Valeur Restante ".$Eentree->prix*$Reste." FC";
                                    }

                                    return $chaine;
                                }



                            })->visibleOn("create")
                            ->hidden(function(Get $get){
                                if(filled($get('elementsentree_id'))){
                                    return false;
                                }else{
                                    return true;
                                }
                            })
                            ->disabled()
                            ->columnSpanFull(),
                            Select::make("elementsentree_id")
                                ->label("Matière Première")
                                ->options(function(){
                                    return Elementsentree::all()->pluck("lib","id");

                                                    // join("entrees","entrees.id","elementsentrees.entree_id")
                                                    //      ->whereProduit_id(session("produit_id"))
                                                    //      ->pluck("elementsentrees.lib","elementsentrees.id");
                                })
                                ->afterStateUpdated(function(Set $set){
                                    $set("qte",null);
                                })
                                ->preload()
                                ->live()
                                ->searchable()
                                ->required(),
                            TextInput::make("qte")
                                ->label("Quantité")
                                ->required()
                                ->disabled(fn(Get $get):bool=> !filled($get("elementsentree_id")))
                                ->placeholder("Ex: 12")
                                ->numeric()
                                ->live()
                                ->afterStateUpdated(function(Get $get, Set $set, $state){

                                    $Eentree=Elementsentree::find($get("elementsentree_id"));

                                    // $set("Total",$state * $Produit->prix);
                                    $set("total",$state *  $Eentree->prix);

                                    if($state> $Eentree->qte){

                                        $set("qte",null);

                                        Notification::make()
                                                    ->title("La quantité saisie dépasse la quantité en stock")
                                                    ->warning()
                                                    ->send();
                                    }

                                })
                        ])->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                //identificaton  de l'élémentsentree utilisé pour la production
                                $Eentree=Elementsentree::find($data['elementsentree_id']);
                                //Dimunition en stock des élémentsentree utilisés pour la production
                                $Eentree->qte -=$data["qte"];
                                $Eentree->update();

                                return $data;
                        })
                    ->columns(2)->columnSpanFull(),

                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('departement.lib')
                    ->label("Departement")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('produit.lib')
                    ->label("Produit")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qte')
                    ->label("Quantité")
                    ->searchable()
                    ->sortable(),
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
                ])->button()->label("Action")
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
            'index' => Pages\ListProductions::route('/'),
            'create' => Pages\CreateProduction::route('/create'),
            'edit' => Pages\EditProduction::route('/{record}/edit'),
        ];
    }
}
