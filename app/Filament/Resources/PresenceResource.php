<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employe;
use App\Models\Presence;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\PresenceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PresenceResource\RelationManagers;

class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';


    protected static ?string $navigationGroup ="NB Management";
    protected static ?int $navigationSort = 27;
    public static function getNavigationBadgeColor():string
    {
        return "success";
    }
    public static function getNavigationBadge():string
    {
        return static::getModel()::where("annee_id",session("Annee_id")[0] ?? 1)
                                ->whereRaw("Date(presences.created_at)=DATE(now())")->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Présence")
                ->aside()
                ->icon("heroicon-o-calendar-days")
                ->description("Signaler votre présence ici!")
                ->schema([
                    Select::make('employe_id')
                        ->relationship("employe","nom")
                        ->preload()
                        ->searchable()
                        ->required(),
                    DateTimePicker::make('arrivee'),
                    DateTimePicker::make('depart'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('nom')
                    ->label("Noms")
                    ->getStateUsing(function($record){
                        $Employe=Employe::whereId($record->employe_id)->first();

                        return $Employe->nom." ".$Employe->postnom;
                    })
                    ->sortable()
                    ->searchable(),

                TextColumn::make('employe.prenom')
                    ->label("Prénom")
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                TextColumn::make('arrivee')
                    ->label("Date/Heure Arrivée")
                    ->dateTime("d/m/Y H:i:s")
                    ->placeholder("n'est pas venu(e)")
                    ->sortable(),
                ToggleColumn::make('BtnDepart')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('depart')
                    ->label("Date/Heure Depart")
                    ->dateTime("d/m/Y H:i:s")
                    ->placeholder(function($record){
                        if($record->BtnArrivee==0){
                            return "n'est pas venu(e)";
                        }else{
                            return "n'est pas encore parti(e)";
                        }

                    })
                    ->sortable(),
                TextColumn::make('status')
                    ->label("Statut")
                    ->badge()
                    ->color(function(String $state){
                        return match($state){
                            "présent(e)"=>"info",
                            "absent(e)"=>"danger",
                        };
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label("En date du")
                    ->dateTime("d/m/Y")
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('Observation')
                    ->searchable()
                    ->placeholder('R.A.S')
                    ->toggleable(),
            ])
            ->filters([
                //
                Filter::make("Presence Aujourd'hui")
                ->query(
                    function ($query){
                        return $query->whereRaw("Date(arrivee)=DATE(now())");
                    }
                ),


                Filter::make('created_at')
                ->form([
                    DatePicker::make('date_debut'),
                    DatePicker::make('date_fin'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['date_debut'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['date_fin'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
            ])
            ->actions([
                ActionGroup::make([

                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make(name: "Départ")
                    ->icon('heroicon-o-user')
                    ->color('info')
                    ->action(function(Presence $presence){
                        //on vérifie si l'employé est déjà parti(e)
                        $check=Presence::whereRaw("id=$presence->id AND DATE(created_at)=DATE(now()) AND BtnDepart=1")->first();

                        //On vérifie si l'employé est absent(e)
                        $check2=$check=Presence::whereRaw("id=$presence->id AND BtnArrivee=0")->exists();;
                        if($check==null){
                            Presence::where("id",$presence->id)->update([
                                "depart"=> now(),
                                "BtnDepart"=> 1,
                            ]);
                            Notification::make()

                            ->title('Départ signalé avec succès')
                            ->success()
                            ->send();
                        }elseif($check2){
                            Notification::make()
                            ->title("Désolé, cet(te) employé(e) n'est pas venu(e) !")
                            ->warning()
                            ->send();
                        }
                        else{
                            Notification::make()
                            ->title("l'employé(e) est déjà parti(e)")
                            ->warning()
                            ->send();
                        }

                    }),
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
            'index' => Pages\ListPresences::route('/'),
            'create' => Pages\CreatePresence::route('/create'),
            'edit' => Pages\EditPresence::route('/{record}/edit'),
        ];
    }
}
