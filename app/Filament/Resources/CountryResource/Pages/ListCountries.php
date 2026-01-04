<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use App\Jobs\GenerateVatRateChanges;
use App\Jobs\UpdateVatRates;
use App\Jobs\VerifyVatRatesIntegrity;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListCountries extends ListRecords
{
    protected static string $resource = CountryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ActionGroup::make([
                Actions\Action::make('updateRates')
                    ->label('Update VAT Rates')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function () {
                        UpdateVatRates::dispatch();
                        Notification::make()
                            ->title('Update job started')
                            ->success()
                            ->send();
                    }),
                Actions\Action::make('generateChanges')
                    ->label('Generate Changes')
                    ->icon('heroicon-o-clock')
                    ->action(function () {
                        GenerateVatRateChanges::dispatch();
                        Notification::make()
                            ->title('Generation job started')
                            ->success()
                            ->send();
                    }),
                Actions\Action::make('verifyIntegrity')
                    ->label('Verify Integrity')
                    ->icon('heroicon-o-shield-check')
                    ->action(function () {
                        VerifyVatRatesIntegrity::dispatch();
                        Notification::make()
                            ->title('Verification job started')
                            ->success()
                            ->send();
                    }),
            ])
            ->label('Actions')
            ->icon('heroicon-m-ellipsis-vertical')
            ->color('primary')
            ->button(),
            
            Actions\CreateAction::make(),
        ];
    }
}
