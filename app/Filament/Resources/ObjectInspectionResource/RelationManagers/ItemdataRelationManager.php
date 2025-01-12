<?php

namespace App\Filament\Resources\ObjectInspectionResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\MaxWidth;
use Filament\Actions;
 
use Filament\Tables\Actions\BulkAction;
//Form
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
 
 
//Tables
use Filament\Tables;
use Filament\Tables\Table;

//Models
use App\Models\ObjectInspectionZincode;
use App\Models\ObjectInspectionData;
use App\Models\systemAction;
use App\Models\ObjectInspection;
;
class ItemdataRelationManager extends RelationManager
{
    protected static string $relationship = "itemdata";
    protected static ?string $title = "Keuringspunten";
    public $action_id;


    protected static bool $isLazy = false;
    public static function getBadge(Model $ownerRecord, string $pageClass) : ? string
    {
 
        return count($ownerRecord?->itemdata);
   
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Forms\Components\TextInput::make("zin_code")
                    ->suffixAction(
                        Action::make("searchZinCode")
                            ->icon("heroicon-m-magnifying-glass")
                            ->action(function (Get $get, Set $set) {
                                $data = ObjectInspectionZincode::where(
                                    "code",
                                    $get("zin_code")
                                )
                                    ->select("description")
                                    ->get();

                                if (count($data) != 0) {
                                    $set("comment", $data[0]->description);
                                }else{
                                    Notification::make()
                                    ->title('Geen ZIN Code gevonden in de database')
                                    ->danger()
                                    ->send();
                                }
                            })
                    ),

                    Select::make("type")->options([
                        "Technisch"     => "Technisch",
                        "Arbotechnisch" => "Arbotechnisch",
                        "Bouwkundig"    => "Bouwkundig",
                    ]),
                    
                    Select::make("status")->options([
                        "Herhaling" => "Herhaling",
                        "Afkeur" => "Afkeur",
                    ]),

                ]),

                Grid::make(1)->schema([
                    TextArea::make("comment")->label(
                        "Omschrijving"
                    ),
                ]),
            ])
            ->columns(4);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute("name")
            ->columns([
              //  Tables\Columns\TextColumn::make("id")->label("#"),
                Tables\Columns\TextColumn::make("zin_code")->label("Code"),

                Tables\Columns\TextColumn::make("comment")
                ->label("Opmerking")
                ->wrap(),
                Tables\Columns\TextColumn::make("type")->label("Type"),
                Tables\Columns\TextColumn::make("status")
                    ->label("Status")
                    ->badge()
                    ->placeholder("-")
                    ->color("warning"),

                    Tables\Columns\TextColumn::make("action_id")
                    ->label("Status")
                    ->badge()
                   
                    ->getStateUsing(function (Model $record): ?string {
                        if ($record?->action_id) {
                            return "Actie aangemaakt";
                        }  else{
                            return false;
                        }
                      
                    })
                    ->placeholder("-"),


            ])
         
            ->paginated(false)
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label("Toevoegen")

                    ->hidden(fn($record) => $this->getOwnerRecord()->external_uuid)

                //    ->hidden(->schedule_run_token)
              
                        ->modalHeading("Keuringspunt toevoegen"),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconbutton()
                    ->modalHeading("Wijzig keuringspunt")
                    ->hidden(fn($record) => $this->getOwnerRecord()->external_uuid),
                Tables\Actions\DeleteAction::make()->iconbutton()
                ->hidden(fn($record) => $this->getOwnerRecord()->external_uuid),
                
            ])

            ->headerActions([
          
    
            ])


            ->bulkActions([

                BulkAction::make('delete')
                ->requiresConfirmation()
                ->label('Actie aanmaken')
                ->modalHeading("Actie aanmaken")
                ->modalDescription(
                    "Hiermee voeg je de keuringspunten toe aan een actie"
                )
   
             
                ->action(function (ObjectInspection $record, Collection $selectedRecords, Get $get) {
                    
                    $action_id = systemAction::insertGetId([
                        'title' =>  "Keuringspunten oplossen",
                        'model' => "ObjectInspection",
                        'item_id' => $this->ownerRecord->id,
                        'create_by_user_id' => auth()->id()
                    ]);

                    
          
                        
                        
                    $selectedRecords->update([
                            'action_id'     =>  $action_id,
                    
    
                    ]);
                        
                   
                })
                
 
                ->deselectRecordsAfterCompletion(),




                    //  ->action(function ($data, $record) {
                    //     $action+Action->create
                       
                    // })
               
      
            ])->emptyState(view('partials.empty-state-small')) ;
    }
}
