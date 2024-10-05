<?php

namespace App\Filament\Resources\ObjectLocationResource\RelationManagers;

use App\Models\Attachment;
use App\Models\ObjectMaintenanceContract;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class AttachmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'attachments';
    //protected static ?string $badge = 'new';

//'model', '','model','filename','original_filename','extention','description','size','user_id','item_id'];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('description')
                    ->rows(7)
                    ->label('Omschrijving')
                    ->columnSpan(3)
                    ->autosize()
                    ->required(),

                FileUpload::make('filename')
                    ->columnSpan(3)
                    ->preserveFilenames()
                    ->required()
                    ->visibility('private')
                    ->directory(function () {
                        $parent_id = $this->getOwnerRecord()->id;  // Assuming you've set up relationships with eloquent
                        return '/uploads/location/' . $parent_id . '/attachments';
                    })


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Medewerker')
                ,



                Tables\Columns\TextColumn::make('created_at')
                    ->label('Datum / tijd')
                    ->sortable()
                    ->dateTime("d-m-Y H:i"),

                Tables\Columns\TextColumn::make('description')->grow(true)->label('Omschrijvinf')
                ,



            ])
            ->filters([
                //
            ])
            ->headerActions([


                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    $data['model'] = "ObjectLocation";
                    return $data;
                }),
            ])
            ->actions([
                Tables\Actions\Action::make('Download')
                    ->label('Download bestand')
                    ->action(fn($record) => Storage::disk('private')
                        ->download($record->filename))
                    ->icon('heroicon-o-document-arrow-down'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


}
