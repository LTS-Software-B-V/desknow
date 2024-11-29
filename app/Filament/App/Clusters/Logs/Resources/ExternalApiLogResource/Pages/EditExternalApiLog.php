<?php

namespace App\Filament\App\Clusters\Logs\Resources\ExternalApiLogResource\Pages;

use App\Filament\App\Clusters\Logs\Resources\ExternalApiLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExternalApiLog extends EditRecord
{
    protected static string $resource = ExternalApiLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
