<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryAnalyticResource\Pages;
use App\Models\CountryAnalytic;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class CountryAnalyticResource extends Resource
{
    protected static ?string $model = CountryAnalytic::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string|UnitEnum|null $navigationGroup = 'Analytics';

    public const TYPES = [
        'view' => 'View',
        'calculator' => 'Calculator',
        'saved' => 'Saved Search',
    ];

    public static function typeColor(?string $state): string
    {
        return match ($state) {
            'calculator' => 'success',
            'saved' => 'warning',
            default => 'primary',
        };
    }

    public static function dateRangeFilter(): Filter
    {
        return Filter::make('created_at')
            ->schema([
                DatePicker::make('from'),
                DatePicker::make('until'),
            ])
            ->query(fn (Builder $query, array $data): Builder => $query
                ->when($data['from'] ?? null, fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                ->when($data['until'] ?? null, fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('country.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (?string $state): string => static::typeColor($state))
                    ->sortable(),
                TextColumn::make('ip_address')
                    ->toggleable(),
                TextColumn::make('location_country')
                    ->sortable(),
                TextColumn::make('location_city')
                    ->toggleable(),
                TextColumn::make('amount')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('rate_used')
                    ->numeric(decimalPlaces: 2)
                    ->suffix('%')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->options(self::TYPES),
                static::dateRangeFilter(),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Analytics Details')
                ->schema([
                    Select::make('type')
                        ->options(self::TYPES)
                        ->disabled(),
                    TextInput::make('ip_address')
                        ->disabled(),
                    TextInput::make('location_country')
                        ->disabled(),
                    TextInput::make('location_city')
                        ->disabled(),
                    TextInput::make('amount')
                        ->numeric()
                        ->prefix('€')
                        ->disabled(),
                    TextInput::make('rate_used')
                        ->numeric()
                        ->suffix('%')
                        ->disabled(),
                    TextInput::make('user_agent')
                        ->columnSpanFull()
                        ->disabled(),
                    TextInput::make('referer')
                        ->columnSpanFull()
                        ->disabled(),
                    KeyValue::make('meta_data')
                        ->columnSpanFull()
                        ->disabled(),
                ])
                ->columns(2)
                ->columnSpanFull(),
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
