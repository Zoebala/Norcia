<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Fonction;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\FonctionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FonctionResource\RelationManagers;

class FonctionResource extends Resource
{
    protected static ?string $model = Fonction::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Fonctions';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 25;
    public static function getNavigationBadge():string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Définition Fonction")
                ->icon("heroicon-o-briefcase")
                ->schema([


                    Wizard::make([
                        Step::make("Informations")
                        ->schema([
                            Forms\Components\TextInput::make('lib')
                            ->label("Désignation de la Fonction")
                            ->required()
                            ->placeholder("Ex: PDG")
                            ->maxLength(255),
                            Toggle::make("employeToggle")
                            ->columnSpanFull()
                            ->label(function(Get $get){
                                if($get('employeToggle')==false){
                                    return "Renseigner les employés ?";
                                }else{
                                    return "Ne pas renseigner les employés ?";
                                }
                            })
                            ->live(),

                        ]),
                        Step::make("Description")
                        ->schema([
                            MarkdownEditor::make('description')->columnSpanFull(),
                        ])
                    ])->columns(2)->columnSpanFull(),

                ])->columns(2),
                Section::make("Définition des employés")
                ->icon("heroicon-o-user-group")
                ->schema([

                    Repeater::make("employes")
                    ->relationship()
                    ->schema([
                        Wizard::make([

                            Wizard\Step::make('Identité')
                                ->schema([
                                    // ...
                                    Section::make("Nouvel Employé ?")
                                    ->description("Ajouter un nouvel employé ici!")
                                    ->icon('heroicon-o-user-plus')
                                    ->schema([

                                        TextInput::make('nom')
                                            ->required()
                                            ->live()
                                            ->placeholder("Ex : Dupon")
                                            ->maxLength(255),
                                        TextInput::make('postnom')
                                            ->required()
                                            ->placeholder("Ex : Vermillion")
                                            ->live()
                                            ->hidden(fn(Get $get):bool => !filled($get("nom")))
                                            ->maxLength(255),
                                        TextInput::make('prenom')
                                            ->required()
                                            ->live()
                                            ->placeholder("Ex : Joe")
                                            ->hidden(fn(Get $get):bool => !filled($get("postnom")))
                                            ->maxLength(255),
                                            Select::make('genre')
                                                ->live()
                                                ->options([
                                                    "F"=>"F",
                                                    "M"=>"M"
                                                ])
                                                ->required()
                                                ->hidden(fn(Get $get):bool => !filled($get("prenom"))),
                                    ])->columnSpan(2),
                                    Section::make("Votre Profil")
                                            ->icon("heroicon-o-camera")
                                            ->description("Uploader votre profil ici!")
                                            ->schema([
                                                // SpatieMediaLibraryFileUpload::make("photo"),
                                                FileUpload::make("photo")->disk("public")->directory("photos"),
                                                DatePicker::make('datenais')
                                                    ->label("Date de naissance")
                                                    ->hidden(fn(Get $get):bool => !filled($get("genre")))
                                                    ->required()
                                                    ->live()
                                                    ->afterStateUpdated(function($state, Set $set){
                                                        $Annee_naissance=(int)date("Y",strtotime($state));
                                                        $A_Actuelle=(int)date("Y");
                                                        if(($A_Actuelle-$Annee_naissance)<17){
                                                            $set("datenais",null);

                                                            Notification::make()
                                                            ->title("Le recrutement ne concerne pas les  moins de 17 ans")
                                                            ->danger()
                                                            ->duration(5000)
                                                            ->send();
                                                        }

                                                    }),

                                    ])->columnSpan(1),
                            ]),

                            Wizard\Step::make('Provenance & Contact')
                                ->schema([
                                    Section::make()
                                    ->schema([

                                        TextInput::make('lieu_naissance')
                                            ->placeholder('Ex: Mbanza-Ngungu')
                                            ->maxLength(255),
                                        Select::make('province')
                                            ->label("Province de Naissance")
                                            ->options([
                                                "kongo Central"=>"kongo Central",
                                                "kinshasa"=>"kinshasa",
                                                "haut-Katanga"=>"haut-Katanga",
                                                "lualaba"=>"lualaba",
                                                "haut-lomani"=>"haut-lomani",
                                                "kolwezi"=>"kolwezi",
                                                "mai-ndombe"=>"mai-ndombe",
                                                "kwilu"=>"kwilu",
                                                "tshopo"=>"tshopo",
                                                "tshuapa"=>"tshuapa",
                                                "ituri"=>"ituri",
                                                "sankuru"=>"sankuru",
                                                "sud-ubangi"=>"sud-ubangi",
                                                "nord-ubangi"=>"nord-ubangi",
                                                "sud-kivu"=>"sud-kivu",
                                                "nord-kivu"=>"sud-kivu",
                                                "bas-uélé"=>"bas-uélé",
                                                "haut-uélé"=>"haut-uélé",
                                                "kasaï"=>"kasaï",
                                                "kasaï-central"=>"kasaï-central",
                                                "kasaï-oriental"=>"kasaï-oriental",
                                                "kwango"=>"kwango",
                                                "lomani"=>"lomani",
                                                "maniema"=>"maniema",
                                                "mongala"=>"mongala",
                                                "tanganyika"=>"tanganyika",
                                                "équateur"=>"équateur",

                                            ]),
                                        TextInput::make('pays_naissance')
                                            ->placeholder('Ex: Nigeria')
                                            ->maxLength(255),
                                        TextInput::make('tel')
                                            ->label("Telephone")
                                            ->tel()
                                            ->placeholder('Ex : 089XXXXXXX')
                                            ->maxLength(10),
                                        TextInput::make('email')
                                            ->placeHolder('Ex: toto@example.com')
                                            ->email(),
                                        TextInput::make('adresse')
                                            ->placeholder('Ex: 45, Av. mweneditu Q/Disengomoka')
                                            ->maxLength(255),


                                    ])->columns(2),
                            ]),
                            Wizard\Step::make('Statut')
                                    ->schema([
                                       Group::make()
                                       ->schema([



                                            Section::make()
                                            ->schema([

                                                Select::make('situation_familiale')
                                                ->options([
                                                "Marié(e)"=>"Marié(e)",
                                                "Célibataire"=>"Célibataire",
                                                "Divorcé(e)"=>"Divorcé(e)",
                                                "Veuf(ve)"=>"Veuf(ve)",
                                            ]),
                                                TextInput::make('Nbre_Enfant')
                                                        ->placeholder('Ex: 2'),

                                                Select::make('position')
                                                    ->options([
                                                        "En activité"=>"En activité",
                                                        "En congé"=>"En congé",
                                                        "En suspension"=>"En suspension"
                                                    ]),
                                               TextInput::make('matricule')
                                                    ->label("Matricule")
                                                    ->placeholder('Ex: 2024/001')
                                                    ->maxLength(255),
                                                Select::make("annee_id")
                                                    ->label("Année d'Embauche")
                                                    ->required()
                                                    ->options(function(){

                                                            return Annee::where("id",session("Annee_id")??1)->pluck('lib','id');

                                                    })->searchable()
                                                    ->preload(),
                                                DatePicker::make("date_embauche")
                                                ->label("Date d'embauche"),



                                            ])->columnSpanFull()->columns(2),
                                       ])->columnSpanFull(),


                            ])->columns(2),
                            Wizard\Step::make("Formations & Etudes Faites")
                                ->schema([
                                    TextInput::make("formation_suivie")
                                    ->placeholder('Ex: Marketing'),
                                    TextInput::make("institution_obt_diplome")
                                    ->placeholder('Ex: ISP_Mbanza-Ngungu'),
                                    TextInput::make("annee_obt_diplome")
                                    ->label("Annee obtention diplôme")
                                    ->placeholder('Ex: 2023-2024')
                                    ->maxLength(9),
                                    TextInput::make("lieu_obt_diplome")
                                    ->label('Lieu Obtention diplôme')
                                    ->placeholder('Ex: Mbanza-Ngungu'),
                                    TextInput::make("pays_obt_diplome")
                                    ->label('Pays obtention diplôme')
                                    ->placeholder('Ex: RDC'),
                                    TextInput::make("qualification")
                                    ->label("Qualification")
                                    ->placeholder("Choisir votre qualification")
                                    ->datalist([
                                        "Docteur" => "Docteur",
                                        "Licencié(e)" => "Licencié(e)",
                                        "Gradué(e)" => "Gradué(e)",
                                        "baccalauréat" => "baccalauréat",
                                    ]),

                            ])->columns(2),
                            Wizard\Step::make("Elements Dossiers")
                            ->schema([
                                FileUpload::make("elements_dossiers")
                                ->label("Mes éléments de dossiers")
                                ->multiple()
                                ->openable()
                                ->downloadable()
                                ->columnSpanFull()
                                ->maxSize("2048")
                                ->disk("public")->directory("dossiers"),
                                // ->visibleOn("edit"),
                                // ->preserveFilenames(),
                            ])
                        ])->columns(3)->columnSpanFull(),
                    ])->columnSpanFull(),
                ])->columns(2)->hidden(fn(Get $get):bool => $get("employeToggle")==false),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lib')
                    ->label("Désignation de la fonction")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label("Description")
                    ->sortable()
                    ->placeholder("Pas de description")
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Créée le")
                    ->dateTime('d/m/Y à H:i:s')
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFonctions::route('/'),
            'create' => Pages\CreateFonction::route('/create'),
            'edit' => Pages\EditFonction::route('/{record}/edit'),
        ];
    }
}
