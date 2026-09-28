<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CountryAnalyticResource;
use App\Models\CountryAnalytic;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestAnalytics extends TableWidget
{
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(CountryAnalytic::query()->with('country')->latest()->limit(5))
            ->paginated(false)
            ->columns([
                TextColumn::make('country.name'),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (?string $state): string => CountryAnalyticResource::typeColor($state)),
                TextColumn::make('amount')
                    ->money('EUR'),
                TextColumn::make('created_at')
                    ->dateTime(),
            ]);
    }
}
