<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Models\Country;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CountryResource extends Resource
{
    /**
     * The resource record title.
     */
    protected static ?string $recordTitleAttribute = 'name';

    /**
     * The resource model.
     */
    protected static ?string $model = Country::class;

    /**
     * The resource icon.
     */
    protected static ?string $navigationIcon = 'heroicon-o-globe';

    /**
     * Get the form for the resource.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\Section::make('Country Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, string $operation, ?string $old, ?string $state) {
                                        if (($get('slug') ?? '') !== Str::slug($old) || $operation !== 'create') {
                                            return;
                                        }

                                        $set('slug', Str::slug($state));
                                    })
                                    ->autofocus(),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->alphaDash()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('super_reduced_rate')
                                    ->numeric()
                                    ->nullable(),

                                Forms\Components\TextInput::make('reduced_rate')
                                    ->nullable(),

                                Forms\Components\TextInput::make('parking_rate')
                                    ->numeric()
                                    ->nullable(),

                                Forms\Components\TextInput::make('standard_rate')
                                    ->numeric()
                                    ->nullable(),

                                Forms\Components\TextInput::make('currency')
                                    ->nullable(),

                                Forms\Components\TextInput::make('currency_code')
                                    ->nullable(),

                                Forms\Components\TextInput::make('currency_symbol')
                                    ->nullable(),

                                Forms\Components\TextInput::make('flag')
                                    ->nullable(),

                                Forms\Components\TextInput::make('iso_code')
                                    ->nullable(),
                            ])
                            ->columnSpan(1),

                        Forms\Components\Section::make('Meta Information')
                            ->schema([
                                Forms\Components\DatePicker::make('created_at')
                                    ->disabled()
                                    ->dehydrated(false),

                                Forms\Components\DatePicker::make('updated_at')
                                    ->disabled()
                                    ->dehydrated(false),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    /**
     * Get the table for the resource.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('super_reduced_rate'),

                Tables\Columns\TextColumn::make('reduced_rate'),

                Tables\Columns\TextColumn::make('parking_rate'),

                Tables\Columns\TextColumn::make('standard_rate'),

                Tables\Columns\TextColumn::make('currency'),

                Tables\Columns\TextColumn::make('currency_code'),

                Tables\Columns\TextColumn::make('currency_symbol'),

                Tables\Columns\TextColumn::make('flag'),

                Tables\Columns\TextColumn::make('iso_code'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Define any filters if necessary
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Get the relationships for the resource.
     */
    public static function getRelations(): array
    {
        return [
            // Define any relationships if necessary
        ];
    }

    /**
     * Get the pages for the resource.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
