<?php

namespace App\Filament\Widgets;

use App\Models\CountryAnalytic;
use App\Models\VatValidationLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $calculations = CountryAnalytic::query()->where('type', 'calculator');
        $since = now()->subDays(30);

        return [
            Stat::make('Total Calculations', number_format((clone $calculations)->count()))
                ->description('Settled calculator results')
                ->descriptionIcon('heroicon-m-calculator')
                ->chart((clone $calculations)->latest()->take(7)->pluck('amount')->map(fn ($amount) => (float) $amount)->reverse()->values()->all()),

            Stat::make('VAT Number Lookups', number_format(VatValidationLog::query()->where('created_at', '>=', $since)->count()))
                ->description('VIES validations in the last 30 days')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('success'),

            Stat::make('Average VAT Rate', number_format((float) (clone $calculations)->avg('rate_used'), 2).'%')
                ->description('Average rate used in calculations')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('warning'),
        ];
    }
}
