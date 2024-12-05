<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employe;
use App\Models\Vendeur;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Pointvente;
use Filament\Tables\Table;

use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\VendeurResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VendeurResource\RelationManagers;
use App\Models\Annee;

class VendeurResource extends Resource
{
    protected static ?string $model = Vendeur::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 60;

    public static function getNavigationBadge():string
    {
        return static::getModel()::count();
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
                Section::make("Définition Vendeur")
                ->icon("heroicon-o-user")
                ->schema([
                    Hidden::make("nom")
                        ->required()
                        ->dehydrated(),
                    Select::make('employe_id')
                        ->label("Employé")
                        ->preload()
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function(Set $set,$state){
                            if($state !=null){

                                $Emp=Employe::find($state);
                                $set("nom",$Emp->nom." ".$Emp->postnom." ".$Emp->prenom);
                            }else{
                                $set("nom",null);
                            }
                        })
                        ->hidden(function(Get $get){
                            if(filled($get("pointvente_id"))){
                                return true;
                            }else{
                                return false;
                            }
                        })
                        ->options(Employe::whereAnnee_id(session("Annee_id") ?? 1)->whereActif(1)->pluck("nom","id")),
                    Select::make('pointvente_id')
                        ->label("Point de Vente")
                        ->preload()
                        ->hidden(function(Get $get){
                            if(filled($get("employe_id"))){
                                return true;
                            }else{
                                return false;
                            }
                        })
                        ->searchable()
                        ->live()
                        ->afterStateUpdated(function(Set $set,$state){
                            if($state !=null){

                                $Pv=Pointvente::find($state);
                                $set("nom",$Pv->lib);
                            }else{
                                $set("nom",null);
                            }
                        })
                        ->options(Pointvente::whereAnnee_id(session("Annee_id")?? 1)->whereActif(1)->pluck("lib","id")),
                    TextInput::make('ville')
                        ->required()
                        ->datalist([
                            "Mbanza-ngungu"=>"Mbanza-ngungu",
                            "Kisantu"=>"Kisantu",
                            "Kwilu-ngongo"=>"Kwilu-ngongo",
                            "Lukala"=>"Lukala",
                            "Matadi"=>"Matadi",
                        ])
                        ->placeholder("Ex: Mbanza-Ngungu"),
                ])->columns(3)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                SelectColumn::make('actif')
                ->label("Actif ?")
                ->options([
                    "1"=>"Oui",
                    "0"=>"Non"
                ]),
                Tables\Columns\TextColumn::make('nom')
                ->label("Vendeur")
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('ville')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Enregistré le")
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendeurs::route('/'),
            'create' => Pages\CreateVendeur::route('/create'),
            'edit' => Pages\EditVendeur::route('/{record}/edit'),
        ];
    }
}
