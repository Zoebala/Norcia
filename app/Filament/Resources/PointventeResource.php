<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Produit;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Concerner;
use App\Models\Pointvente;
use Filament\Tables\Table;
use App\Models\Departement;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PointventeResource\Pages;
use App\Filament\Resources\PointventeResource\RelationManagers;
use App\Filament\Resources\PointventeResource\RelationManagers\DepartementsRelationManager;

class PointventeResource extends Resource
{
    protected static ?string $model = Pointvente::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'Points de Vente';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 40;
    public static function getNavigationBadge():string
    {
        return static::getModel()::where("annee_id",session("Annee_id")??1)->count();
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
                //
                Section::make("Définiton d'un point de vente")
                ->icon("heroicon-o-home-modern")
                ->schema([
                    Select::make("annee_id")
                    ->label("Année")
                    ->required()
                    ->options(function(){
                        return Annee::whereId(session("Annee_id") ?? 1)->pluck("lib","id");
                    })->preload()
                    ->searchable(),
                    TextInput::make('lib')
                        ->label("Désignation point de vente")
                        ->placeholder("Ex : Munich")
                        ->maxlength(25)
                        ->live()
                        ->afterStateUpdated(function(Get $get, Set $set){
                            if(filled($get("annee_id") && filled($get("lib")))){
                                $Pv=Pointvente::whereAnnee_id($get("annee_id"))->whereLib($get("lib"))->exists();
                                if($Pv){
                                    $set("annee_id",null);
                                    $set("lib",null);
                                    Notification::make()->title("Ce Point de vente existe déjà pour l'année indiquée !")->danger()->send();
                                }
                            }
                        })
                        ->required(),
                    TextInput::make("tel")
                    ->label("Téléphone")
                    ->required()
                    ->placeholder("Ex: 089XXXXXXX")
                    ->maxlength(10),
                    TextInput::make("adresse")
                    ->label("Adresse")
                    ->required()
                    ->placeholder("Ex: 12, Av. Mobutu Q/Loma"),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                ToggleColumn::make("actif")
                ->label("Actif ?"),
                TextColumn::make("annee.lib")
                ->label("Annee")
                ->searchable()
                ->sortable(),
                TextColumn::make("lib")
                ->label("Point de Vente")
                ->searchable()
                ->sortable(),
                TextColumn::make("tel")
                ->label("Téléphone")
                ->searchable()
                ->sortable(),
                TextColumn::make("adresse")
                ->label("Adresse")
                ->searchable()
                ->sortable(),
                TextColumn::make("created_at")
                ->label("Créé le ")
                ->dateTime("d/m/Y à H:i:s")
                ->searchable()
                ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([

                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make("Ajouter Produit(s)")
                    ->icon("heroicon-o-plus-circle")
                    ->form([
                        Select::make("departement_id")
                        ->label("Departement")
                        ->options(function(Pointvente $Pv){

                            return Departement::join("concerners","concerners.departement_id","departements.id")
                                            ->join("pointventes","pointventes.id","concerners.pointvente_id")
                                            ->where("departements.annee_id",session("Annee_id") ?? 1)
                                            ->where("concerners.pointvente_id",$Pv->id)
                                            ->where("departements.actif",1)
                                            ->pluck("departements.lib","departements.id");
                        })
                        ->required()
                        ->preload()
                        ->searchable()
                        ->live(),
                        Select::make("produit_id")
                        ->label("Produit(s)")
                        ->multiple()

                        ->options(function(Get $get){
                            return Produit::whereDepartement_id($get("departement_id"))->whereActif(1)->pluck("lib","id");
                        })
                        ->preload()
                        ->searchable()
                        ->required()
                        ->live(),
                    ])->modalWidth(MaxWidth::Medium)
                    ->modalIcon("heroicon-o-shopping-bag")
                    ->action(function(array $data,Pointvente $Pv){

                        //identification de l'enregistrement dans la table concerners et modification de l'enregistrement
                        Concerner::Where("pointvente_id",$Pv->id)
                                  ->Where("departement_id",$data["departement_id"])
                                  ->update([
                                        "produit_id" => $data["produit_id"],
                                  ]);
                        Notification::make()
                        ->title("Affectation des produits effectuée avec succès")
                        ->success()
                        ->send();
                        // return redirect()->route("")

                    }),
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
            DepartementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPointventes::route('/'),
            'create' => Pages\CreatePointvente::route('/create'),
            'edit' => Pages\EditPointvente::route('/{record}/edit'),
        ];
    }
}
