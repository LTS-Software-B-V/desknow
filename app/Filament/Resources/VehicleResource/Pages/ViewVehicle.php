<?php
namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Resources\VehicleResource;
use Filament\Resources\Pages\ViewRecord;

class ViewVehicle extends ViewRecord
{
    protected static string $resource = VehicleResource::class;

    // public static function getWidgets(): array
    // {
    //     return [
    //         VehicleResource\Widgets\TrackFrame::class,
    //     ];
    // }

}
