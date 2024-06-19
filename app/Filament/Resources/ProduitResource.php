<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Produit;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Departement;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProduitResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProduitResource\RelationManagers;

class ProduitResource extends Resource
{
    protected static ?string $model = Produit::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 30;
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
                Group::make([

                    Section::make("Définition du Produit")
                    ->icon("heroicon-o-shopping-bag")
                    ->schema([
                        Select::make("annee_id")
                        ->label("Année")
                        ->options(function(){
                            return Annee::whereId(session("Annee_id") ?? 1)->pluck("lib","id");
                        })->preload()
                        ->searchable()
                        ->required()
                        ->columnSpan(1),
                        Select::make("departement_id")
                        ->label("Departement")
                        ->options(function(){
                            return Departement::where("annee_id",session("Annee_id") ?? 1)
                                                ->whereActif(1)
                                                ->pluck("lib","id");
                        })->preload()
                        ->searchable()
                        ->required()
                        ->columnSpan(1),
                        TextInput::make('lib')
                            ->label("Produit")
                            ->required()
                            ->placeholder("Ex: Jus de Pomme")
                            ->maxLength(20)
                            ->live()
                            ->afterStateUpdated(function(Get $get, Set $set){
                                    if(filled($get("annee_id")) && filled($get("departement_id")) && filled($get("lib"))){

                                        $produit=Produit::where("lib",$get("lib"))
                                                                ->where("annee_id",$get("annee_id"))
                                                                ->where("departement_id",$get("departement_id"))
                                                                ->exists();

                                        if($produit){
                                            $set("annee_id",null);
                                            $set("departement_id",null);
                                            $set("lib",null);
                                            Notification::make()->title("Ce produit existe déjà pour l'année et le département indiqués !")->danger()->send();
                                        }
                                    }
                                })
                            ->columnSpan(1),
                        TextInput::make('qte')
                            ->label("Quantité")
                            ->required()
                            ->integer()
                            ->placeholder("Ex: 50")
                            ->maxValue(1000)
                            ->minValue(10)
                            ->columnSpan(1),
                            TextInput::make("prix")
                                    ->label("Prix Unitaire")
                                    ->required()
                                    ->placeholder("Ex: 1500")
                                    ->MaxValue(10000)
                                    // ->minValue(100)
                                    ->suffix("FC")
                                    ->columnSpanFull(),
                    ])->columnSpan(2)->columns(2),
                    Section::make("Définition du Produit")
                    ->icon("heroicon-o-camera")
                    ->description('la photo du produit')
                    ->schema([

                        FileUpload::make('photo')
                            ->label("Photo")
                            ->required()
                            ->openable()
                            ->downloadable()
                            ->disk("public")->directory('produits'),
                    ])->columnSpan(1),
                ])->columns(3)->columnSpanFull(),
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
                ->label("Année")
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make("departement.lib")
                ->label("Departement")
                ->searchable()
                ->sortable(),
                TextColumn::make("lib")
                ->label("Produit")
                ->searchable()
                ->sortable(),
                ImageColumn::make("photo")
                ->label("Photo"),
                TextColumn::make("qte")
                ->label("Quantité")
                ->searchable()
                ->sortable(),
                TextColumn::make("prix")
                ->label("Prix Unitaire")
                ->searchable()
                ->suffix(" FC")
                ->sortable(),
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
                    Tables\Actions\Action::make("production")
                    ->icon("heroicon-o-archive-box")
                    ->color("success")
                    ->form([
                        Select::make("departement_id")
                        ->label("Département")
                        ->required()
                        ->live()
                        ->options(Departement::where("annee_id",session("Annee_id"))->whereActif(1)->pluck("lib","id"))
                        ->preload()
                        ->searchable()->columnSpan(1),
                        Select::make("produit_id")
                        ->label("Produit")
                        ->required()
                        ->options(function(Get $get){
                            return Produit::whereDepartement_id($get("departement_id"))->whereActif(1)->pluck("lib","id");
                        })
                        ->searchable()
                        ->preload(),
                    ])
                    ->action(function(){

                    })
                    ->modalWidth(MaxWidth::Medium)
                    ->modalIcon("heroicon-o-archive-box") ,
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
            'index' => Pages\ListProduits::route('/'),
            'create' => Pages\CreateProduit::route('/create'),
            'edit' => Pages\EditProduit::route('/{record}/edit'),
        ];
    }
}
