<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Annee;
use App\Models\Employe;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Fonction;
use App\Models\Presence;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeResource\RelationManagers;
use App\Filament\Resources\EmployeResource\RelationManagers\FonctionRelationManager;
use App\Filament\Resources\EmployeResource\RelationManagers\DepartementsRelationManager;



class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;


    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Employés';
    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 26;
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

                Section::make("Définition des employés")
                ->icon("heroicon-o-user-group")
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
                                                Select::make("fonction_id")
                                                ->label("Fonction")
                                                ->relationship("fonction",'lib')
                                                ->preload()
                                                ->searchable()
                                                ->columnSpanFull()
                                                ->required()



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

                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                ToggleColumn::make('actif')
                ->label("Actif ?")
                ->toggleable(isToggledHiddenByDefault: false),
            Tables\Columns\TextColumn::make('fonction.lib')
                ->label("Fonction")
                ->placeholder("Pas de Fonction")
                ->searchable()
                ->formatStateUsing(function($state){
                    if(mb_strlen($state)>10)
                        return substr($state,0,12)."...";
                    else
                        return $state;
                })
                ->sortable(),
            Tables\Columns\TextColumn::make('matricule')
                ->label("Matricule")
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('nom')
                ->label("Nom Complet")
                ->getStateUsing(fn($record)=> $record->nom." ".$record->postnom." ".$record->prenom)
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('genre')
                ->label("Genre")
                ->sortable()
                ->searchable(),
            Tables\Columns\ImageColumn::make('photo')
                ->label("Photo")
                ->placeholder("Pas de Profil")
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
            Tables\Columns\ImageColumn::make('elements_dossiers')
                ->label("Mes éléments de dossier")
                ->placeholder("N'a pas d'éléménts dossier")
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
            Tables\Columns\TextColumn::make('province')
                ->label("Province")
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('datenais')
                ->label("Date de naissance")
                ->date("d/m/Y")
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
                    Tables\Actions\Action::make(name: 'présent(e)')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function(Employe $employe){

                        //vérifie si l'employé existe déjà
                        $check=Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now())")->first();
                        //vérifie si l'employé est absent(e)
                        $check1=Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=0")->exists();
                        // dd($check1);

                        if($check==null){

                            Presence::create([
                                'employe_id' => $employe->id,
                                'arrivee' => now(),
                                'BtnArrivee' => 1,
                                'status' => 'présent(e)',
                                'annee_id' => session('Annee_id') ?? 1,
                            ]);

                            Notification::make()
                            ->title("Présence de l'employé(e) $employe->nom $employe->postnom signalée avec succès")
                            ->success()
                            ->send();
                            //on vérifie si l'employé n'a pas déjà été déclaré(e) comme absent(e)
                            return redirect()->route('filament.admin.resources.presences.index');
                        }elseif($check1){

                                Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=0")->delete();
                                Presence::create([
                                    'employe_id' => $employe->id,
                                    'arrivee' => now(),
                                    'BtnArrivee' => 1,
                                    'status' => 'présent(e)',
                                    'annee_id' => session('Annee_id') ?? 1,
                                ]);

                                Notification::make()
                                ->title("Présence de l'employé(e) $employe->nom $employe->postnom signalée avec succès")
                                ->success()
                                ->send();
                                return redirect()->route('filament.admin.resources.presences.index');
                        }else{

                                Notification::make()
                                ->title("l'employé $employe->nom $employe->postnom est déjà présent(e)")
                                ->warning()
                                ->send();
                        }


                    }),
                    Tables\Actions\Action::make(name: 'Absent(e)')
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->form([
                        TextInput::make("Observation")
                        ->label("Indiquez la raison de votre absence")
                        ->maxLength("25")

                        ->required()
                        ->datalist(
                            [

                                "malade" =>"malade",
                                "en vancances"=>"en vancances",
                                "empêché " =>"empêché",
                            ]
                        )

                    ])
                    ->action(function(Employe $employe, array $data){

                        //on vérifie si l'employé n'a pas déjà été déclarée comme présent(e)
                        $check=Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=1")->exists();
                        // on vérifie  si l'employe n'a pas déjà été déclaré comme absent(e)
                        $check2=Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=0")->exists();

                        if($check){
                            Presence::whereRaw("employe_id=$employe->id AND DATE(created_at)=DATE(now()) AND BtnArrivee=1")->delete();
                            Presence::create([
                                'employe_id' => $employe->id,
                                'arrivee'=>null,
                                'depart'=>null,
                                'status'=>'absent(e)',
                                'Observation' => $data["Observation"],
                                'BtnArrivee' => 0,
                                'annee_id' => session('Annee_id') ?? 1,
                            ]);

                            Notification::make()
                            ->title("l'absence de l'employé $employe->nom $employe->postnom signalée avec succès")
                            // ->successRedirectUrl("presences.list")
                            ->success()
                            ->send();
                            return redirect()->route('filament.admin.resources.presences.index');
                        //on vérifie si l'employé n'a pas déjà été déclaré(e) comme absent(e)
                        }elseif($check2){
                            Notification::make()
                            ->title("l'absence de l'employé(e) $employe->nom $employe->postnom a déjà été signalée")
                            ->warning()
                            ->send();
                        }
                        else{
                            //si l'employé n'a pas encore été déjà déclaré(e)
                            Presence::create([
                                'employe_id' => $employe->id,
                                'Observation' => $data["Observation"],
                                'BtnArrivee' => 0,
                                'status' =>"absent(e)",
                                'annee_id' => session('Annee_id') ?? 1,
                            ]);
                            Notification::make()
                            ->title("l'absence de l'employé $employe->nom $employe->postnom signalée avec succès")
                            ->success()
                            ->send();
                            return redirect()->route('filament.admin.resources.presences.index');

                        }

                    })
                    ->modalWidth(MaxWidth::Medium)
                    ->modalIcon("heroicon-o-chat-bubble-left") ,
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
            DepartementsRelationManager::class,
            FonctionRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployes::route('/'),
            'create' => Pages\CreateEmploye::route('/create'),
            'edit' => Pages\EditEmploye::route('/{record}/edit'),
        ];
    }
}
