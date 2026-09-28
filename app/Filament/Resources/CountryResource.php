<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers\AnalyticsRelationManager;
use App\Models\Country;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class CountryResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-globe-europe-africa';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Country')
                ->tabs([
                    Tab::make('Basic Information')
                        ->icon('heroicon-m-information-circle')
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('name')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(function (Get $get, Set $set, string $operation, ?string $old, ?string $state) {
                                            if (($get('slug') ?? '') !== Str::slug((string) $old) || $operation !== 'create') {
                                                return;
                                            }
                                            $set('slug', Str::slug((string) $state));
                                        }),

                                    TextInput::make('slug')
                                        ->required()
                                        ->alphaDash()
                                        ->unique(ignoreRecord: true)
                                        ->maxLength(255),

                                    TextInput::make('iso_code')
                                        ->required()
                                        ->length(2)
                                        ->formatStateUsing(fn (?string $state) => strtoupper((string) $state))
                                        ->rules(['required', 'size:2', 'alpha']),

                                    TextInput::make('flag')
                                        ->prefix('flag-')
                                        ->suffix('.svg')
                                        ->helperText('Flag icon identifier'),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                        ]),

                    Tab::make('VAT Rates')
                        ->icon('heroicon-m-currency-euro')
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('standard_rate')
                                        ->numeric()
                                        ->required()
                                        ->suffix('%')
                                        ->minValue(0)
                                        ->maxValue(100),

                                    TextInput::make('reduced_rate')
                                        ->helperText('One rate, or several separated by " / " (e.g. "5 / 9")')
                                        ->regex('/^\s*\d+(?:[.,]\d+)?(?:\s*[\/;|]\s*\d+(?:[.,]\d+)?)*\s*$/')
                                        ->suffix('%'),

                                    TextInput::make('super_reduced_rate')
                                        ->numeric()
                                        ->suffix('%')
                                        ->minValue(0)
                                        ->maxValue(100),

                                    TextInput::make('parking_rate')
                                        ->numeric()
                                        ->suffix('%')
                                        ->minValue(0)
                                        ->maxValue(100),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                        ]),

                    Tab::make('Currency')
                        ->icon('heroicon-m-banknotes')
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('currency')
                                        ->required(),

                                    TextInput::make('currency_code')
                                        ->required()
                                        ->length(3)
                                        ->formatStateUsing(fn (?string $state) => strtoupper((string) $state))
                                        ->rules(['required', 'size:3', 'alpha']),

                                    TextInput::make('currency_symbol')
                                        ->required()
                                        ->maxLength(5),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('iso_code')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                TextColumn::make('analytics_count')
                    ->counts('analytics')
                    ->label('Calculations')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('standard_rate')
                    ->numeric()
                    ->suffix('%')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('reduced_rate')
                    ->suffix('%')
                    ->alignCenter(),
            ])
            ->filters([
                TernaryFilter::make('has_reduced_rate')
                    ->label('Reduced rate')
                    ->trueLabel('With reduced rate')
                    ->falseLabel('Without reduced rate')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('reduced_rate')->where('reduced_rate', '!=', ''),
                        false: fn (Builder $query) => $query->where(fn (Builder $query) => $query->whereNull('reduced_rate')->orWhere('reduced_rate', '')),
                        blank: fn (Builder $query) => $query,
                    ),
                Filter::make('high_vat')
                    ->label('Standard rate ≥ 20%')
                    ->query(fn (Builder $query) => $query->where('standard_rate', '>=', 20)),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('analytics_count', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            AuditsRelationManager::class,
            AnalyticsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'view' => Pages\ViewCountry::route('/{record}'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
