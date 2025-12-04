<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Filament\Resources\CountryResource\RelationManagers\AnalyticsRelationManager;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class CountryResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-europe-africa';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Country')
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Basic Information')
                        ->icon('heroicon-m-information-circle')
                        ->schema([
                            Forms\Components\Section::make([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, string $operation, ?string $old, ?string $state) {
                                        if (($get('slug') ?? '') !== Str::slug($old) || $operation !== 'create') {
                                            return;
                                        }
                                        $set('slug', Str::slug($state));
                                    }),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->alphaDash()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('iso_code')
                                    ->required()
                                    ->length(2)
                                    ->formatStateUsing(fn ($state) => strtoupper($state))
                                    ->rules(['required', 'size:2', 'alpha']),

                                Forms\Components\TextInput::make('flag')
                                    ->prefix('flag-')
                                    ->suffix('.svg')
                                    ->helperText('Flag icon identifier'),
                            ])->columns(2),
                        ]),

                    Forms\Components\Tabs\Tab::make('VAT Rates')
                        ->icon('heroicon-m-currency-euro')
                        ->schema([
                            Forms\Components\Section::make([
                                Forms\Components\TextInput::make('standard_rate')
                                    ->numeric()
                                    ->required()
                                    ->suffix('%')
                                    ->minValue(0)
                                    ->maxValue(100),

                                Forms\Components\TextInput::make('reduced_rate')
                                    ->helperText('Can be a range like "5 / 9"')
                                    ->suffix('%'),

                                Forms\Components\TextInput::make('super_reduced_rate')
                                    ->numeric()
                                    ->suffix('%')
                                    ->minValue(0)
                                    ->maxValue(100),

                                Forms\Components\TextInput::make('parking_rate')
                                    ->numeric()
                                    ->suffix('%')
                                    ->minValue(0)
                                    ->maxValue(100),
                            ])->columns(2),
                        ]),

                    Forms\Components\Tabs\Tab::make('Currency')
                        ->icon('heroicon-m-banknotes')
                        ->schema([
                            Forms\Components\Section::make([
                                Forms\Components\TextInput::make('currency')
                                    ->required(),

                                Forms\Components\TextInput::make('currency_code')
                                    ->required()
                                    ->length(3)
                                    ->formatStateUsing(fn ($state) => strtoupper($state))
                                    ->rules(['required', 'size:3', 'alpha']),

                                Forms\Components\TextInput::make('currency_symbol')
                                    ->required()
                                    ->maxLength(5),
                            ])->columns(2),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('iso_code')
                    ->badge()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('analytics_count')
                    ->counts('analytics')
                    ->label('Calculations')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('standard_rate')
                    ->numeric()
                    ->suffix('%')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('reduced_rate')
                    ->suffix('%')
                    ->alignCenter(),

                // Tables\Columns\TextColumn::make('currency_code')
                //     ->badge()
                //     ->color('success'),

                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('has_reduced_rate')
                    ->options([
                        true => 'With reduced rate',
                        false => 'Without reduced rate',
                    ])
                    ->query(function ($query, $data) {
                        if ($data['value'] === true) {
                            return $query->whereNotNull('reduced_rate');
                        }
                        if ($data['value'] === false) {
                            return $query->whereNull('reduced_rate');
                        }
                    }),
                Tables\Filters\Filter::make('high_vat')
                    ->query(fn ($query) => $query->where('standard_rate', '>=', 20)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('analytics_count', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('analytics');
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
