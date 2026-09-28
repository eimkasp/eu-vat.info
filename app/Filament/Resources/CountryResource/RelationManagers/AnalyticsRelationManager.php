<?php

namespace App\Filament\Resources\CountryResource\RelationManagers;

use App\Filament\Resources\CountryAnalyticResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AnalyticsRelationManager extends RelationManager
{
    protected static string $relationship = 'analytics';

    protected static ?string $title = 'Country Analytics';

    protected static ?string $recordTitleAttribute = 'type';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (?string $state): string => CountryAnalyticResource::typeColor($state))
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('rate_used')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('location_country')
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')->options(CountryAnalyticResource::TYPES),
                CountryAnalyticResource::dateRangeFilter(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
