<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class IncidentChart extends ChartWidget
{
    protected static ?string $heading = 'Storingen';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = '4';
    protected function getData(): array
    {

          return [
              'datasets' => [
                  [
                      'label' => 'Aangemeld',
                      'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                  ],
                  [
                      'label' => 'Opgelost',
                      'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                  ],

              ],
              'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],


        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
