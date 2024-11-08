<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryAnalyticResource\Pages;
use App\Models\CountryAnalytic;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CountryAnalyticResource extends Resource
{
    protected static ?string $model = CountryAnalytic::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Analytics';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->sortable()
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('ip_address')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('location_country')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location_city')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('rate_used')
                    ->numeric(2)
                    ->suffix('%')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'view' => 'View',
                        'calculator' => 'Calculator',
                        'saved' => 'Saved Search',
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
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Analytics Details')
                    ->schema([
                        \Filament\Forms\Components\Select::make('type')
                            ->options([
                                'view' => 'View',
                                'calculator' => 'Calculator',
                                'saved' => 'Saved Search',
                            ])
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('ip_address')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('location_country')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('location_city')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->prefix('€')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('rate_used')
                            ->numeric()
                            ->suffix('%')
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('user_agent')
                            ->columnSpanFull()
                            ->disabled(),
                        \Filament\Forms\Components\TextInput::make('referer')
                            ->columnSpanFull()
                            ->disabled(),
                        \Filament\Forms\Components\KeyValue::make('meta_data')
                            ->columnSpanFull()
                            ->disabled(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountryAnalytics::route('/'),
            'view' => Pages\ViewCountryAnalytic::route('/{record}'),
        ];
    }
}
