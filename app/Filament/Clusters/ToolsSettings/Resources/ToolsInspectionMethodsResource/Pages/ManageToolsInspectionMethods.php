<?php

namespace App\Filament\Clusters\ToolsSettings\Resources\ToolsInspectionMethodsResource\Pages;

use App\Filament\Clusters\ToolsSettings\Resources\ToolsInspectionMethodsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions\Action;

class ManageToolsInspectionMethods extends ManageRecords
{
    protected static ?string $title = 'Gereedschap - Keuringsmethodes';

    protected static string $resource = ToolsInspectionMethodsResource::class;

    protected function getHeaderActions(): array
    {
        return [

            
            Action::make('back')
            ->url(route('filament.admin.resources.tools.index'))
            ->label('Terug naar gereedschappen') 
            ->link()
            ->color('gray'),

            \EightyNine\ExcelImport\ExcelImportAction::make()
            ->color("success")->label('Importeren')->modalHeading('Selecteer een excel bestand'),
    
            Actions\CreateAction::make()->label('Toevoegen'),
        ];
    }
}
