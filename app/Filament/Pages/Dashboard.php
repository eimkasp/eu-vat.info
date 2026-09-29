<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CountryStatsChart;
use App\Filament\Widgets\LatestAnalytics;
use App\Filament\Widgets\StatsOverview;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard as BaseDashboard;
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
                    ->action(function (): void {
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
                    ->action(function (): void {
                        Artisan::call('optimize:clear');
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
