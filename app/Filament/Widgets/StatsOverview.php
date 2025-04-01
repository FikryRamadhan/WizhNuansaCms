<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            Stat::make('Total Penduduk', '5.096 Orang')
                ->icon('heroicon-o-user-group')
                ->description('Berdasarkan data terakhir diinput'),
            Stat::make('Dusun Pahing', '100 Orang')
                ->description('10% Naik dari bulan lalu')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('Dusun Wage', '20 Orang')
                ->description('10% Menurun dari bulan lalu')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([2, 3, 10, 13, 6, 4, 2])
                ->color('danger'),
        ];
    }

    protected function getType(): string
    {
        return 'scatter';
    }
}
