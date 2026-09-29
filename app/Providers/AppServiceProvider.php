<?php

namespace App\Providers;

use App\Models\User;
use App\Support\Mcp\VatMcpServer;
use Filament\Facades\Filament;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::define('viewPulse', fn (User $user): bool => $user->canAccessPanel(Filament::getPanel('admin')));

        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(120)->by($request->ip()));
        RateLimiter::for('vies', fn (Request $request) => Limit::perMinute(20)->by($request->ip()));
        RateLimiter::for('mcp', fn (Request $request) => Limit::perMinute(VatMcpServer::REQUESTS_PER_MINUTE)->by($request->ip()));
    }
}
