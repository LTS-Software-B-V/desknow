<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ObjectsLocationsResource\Pages;
use App\Filament\Resources\ObjectsLocationsResource\RelationManagers;
use App\Models\objectLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ObjectsLocationsResource extends Resource
{
    protected static ?string $model = objectLocation::class;
     
    protected static ? string $navigationGroup = 'Objecten';
    protected static ? string $navigationLabel = 'Locaties';  

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListObjectsLocations::route('/'),
            'create' => Pages\CreateObjectsLocations::route('/create'),
            'edit' => Pages\EditObjectsLocations::route('/{record}/edit'),
        ];
    }
}