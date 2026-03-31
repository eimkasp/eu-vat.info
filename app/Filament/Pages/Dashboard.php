<?php

namespace App\Filament\Pages;

use App\Models\CountryAnalytic;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

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

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('clearFullPageCache')
                    ->label('Remove Full-Page Cache')
                    ->icon('heroicon-o-rectangle-stack')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Clear Full-Page Cache')
                    ->modalDescription('This will clear compiled views and the application cache. Pages will be rebuilt on next request.')
                    ->action(function () {
                        Cache::flush();
                        Artisan::call('view:clear');
                        Notification::make()
                            ->title('Full-page cache cleared')
                            ->success()
                            ->send();
                    }),

                Action::make('clearAllCache')
                    ->label('Remove All Cache')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Clear All Caches')
                    ->modalDescription('This will clear the application cache, compiled views, config, and route caches. The site will rebuild on next request.')
                    ->action(function () {
                        Artisan::call('cache:clear');
                        Artisan::call('view:clear');
                        Artisan::call('config:clear');
                        Artisan::call('route:clear');
                        Notification::make()
                            ->title('All caches cleared')
                            ->success()
                            ->send();
                    }),
            ])
            ->icon('heroicon-o-cog-6-tooth')
            ->label('Cache')
            ->button(),
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

            Stat::make('Average VAT Rate', number_format(CountryAnalytic::avg('rate_used'), 2).'%')
                ->description('Average VAT rate used')
                ->descriptionIcon('heroicon-m-currency-euro')
                ->color('warning'),
        ];
    }
}
