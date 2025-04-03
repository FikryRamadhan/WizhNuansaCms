<?php

namespace App\Filament\Widgets;


use App\Models\User;
use App\Models\Tour;
use App\Models\Coffe;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Forms\Components\DatePicker;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Tables\Filters\Filter;

class DashboardStats extends StatsOverviewWidget
{
    public ?string $startDate = null;
    public ?string $endDate = null;

    protected function getFilters(): array
    {
        return [
            Filter::make('Tanggal Mulai')
                ->form([
                    DatePicker::make('startDate')
                        ->label('Tanggal Mulai')
                        ->reactive(),
                    DatePicker::make('endDate')
                        ->label('Tanggal Akhir')
                        ->reactive(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if ($data['startDate']) {
                        $query->whereDate('created_at', '>=', Carbon::parse($data['startDate']));
                    }
                    if ($data['endDate']) {
                        $query->whereDate('created_at', '<=', Carbon::parse($data['endDate']));
                    }
                    return $query;
                }),
        ];
    }

    protected function getStats(): array
    {
        $usersQuery = $this->applyDateFilter(User::query());
        $toursQuery = $this->applyDateFilter(Tour::query());
        $coffesQuery = $this->applyDateFilter(Coffe::query());

        return [
            Stat::make('Total Users', $usersQuery->count() . ' Orang')
                ->icon('heroicon-o-user')
                ->description('Jumlah pengguna yang terdaftar')
                ->chart($this->getChartData($usersQuery))
                ->color('success'),

            Stat::make('Total Tours', $toursQuery->count() . ' Tempat')
                ->icon('heroicon-o-map')
                ->description('Jumlah destinasi wisata yang terdaftar')
                ->chart($this->getChartData($toursQuery))
                ->color('primary'),

            Stat::make('Total Coffe Shops', $coffesQuery->count() . ' Tempat')
                ->icon('heroicon-o-map')
                ->description('Jumlah kedai kopi yang terdaftar')
                ->chart($this->getChartData($coffesQuery))
                ->color('warning'),
        ];
    }

    protected function applyDateFilter(Builder $query): Builder
    {
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($this->startDate));
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($this->endDate));
        }
        return $query;
    }

    protected function getChartData(Builder $query): array
    {
        return $query->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count')
            ->toArray();
    }
}
