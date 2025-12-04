<?php

namespace App\Filament\Resources\CountryResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AnalyticsRelationManager extends RelationManager
{
    protected static string $relationship = 'analytics';

    protected static ?string $title = 'Country Analytics';

    protected static ?string $recordTitleAttribute = 'type';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'view',
                        'success' => 'calculator',
                        'warning' => 'saved',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate_used')
                    ->numeric(2)
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location_country')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'calculator' => 'Calculator',
                        'saved' => 'Saved Search',
                        'view' => 'View',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from'),
                        \Filament\Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
