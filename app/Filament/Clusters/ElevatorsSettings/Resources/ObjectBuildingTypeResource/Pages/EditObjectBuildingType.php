<?php

namespace App\Filament\Clusters\ElevatorsSettings\Resources\ObjectBuildingTypeResource\Pages;

use App\Filament\Clusters\ElevatorsSettings\Resources\ObjectBuildingTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditObjectBuildingType extends EditRecord
{
    protected static string $resource = ObjectBuildingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
