<?php

namespace App\Filament\Pages;

use App\Models\CountryAnalytic;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            LatestAnalytics::class,
            CountryStatsChart::class,
        ];
    }
}

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Calculations', CountryAnalytic::where('type', 'calculator')->count())
                ->description('Total VAT calculations')
                ->descriptionIcon('heroicon-m-calculator')
                ->chart(CountryAnalytic::where('type', 'calculator')
                    ->latest()
                    ->take(7)
                    ->pluck('amount')
                    ->toArray()),

            Stat::make('Saved Searches', CountryAnalytic::where('type', 'saved')->count())
                ->description('Total saved searches')
                ->descriptionIcon('heroicon-m-bookmark')
                ->color('success'),

            Stat::make('Average VAT Rate', number_format(CountryAnalytic::avg('rate_used'), 2) . '%')
                ->description('Average VAT rate used')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('warning'),
        ];
    }
}
