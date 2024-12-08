<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Projects extends BaseWidget
{
    protected static ?int $sort =7;
    protected int | string | array $columnSpan = '6';
    protected static ?string $heading = 'Projecten';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Project::query()->latest()
            )
            ->columns([
                // ...
            ]);
    }
}
