<?php

use App\Jobs\GenerateVatRateChanges;
use App\Jobs\UpdateVatRates;
use App\Jobs\VerifyVatRatesIntegrity;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/*
|--------------------------------------------------------------------------
| VAT Data Refresh Schedule
|--------------------------------------------------------------------------
| Weekly: Download latest VAT rates from kdeldycke/vat-rates GitHub repo
| Daily:  Publish the reviewed VAT change ledger (data/vat_changes.csv)
| Daily:  Verify integrity between vat_rates and countries tables
| Daily:  Generate change records for the VAT history/changelog
| Weekly: Audit stored rates against the European Commission's TEDB
*/

Schedule::job(new UpdateVatRates)->weeklyOn(1, '03:00')
    ->withoutOverlapping()
    ->onOneServer()
    ->appendOutputTo(storage_path('logs/vat-refresh.log'));

$vatChangeImport = Schedule::command('vat-changes:import --notify')->dailyAt('03:30')
    ->withoutOverlapping()
    ->onOneServer()
    ->appendOutputTo(storage_path('logs/vat-changes.log'));

Schedule::job(new VerifyVatRatesIntegrity)->dailyAt('04:00')
    ->withoutOverlapping()
    ->onOneServer();

Schedule::job(new GenerateVatRateChanges)->dailyAt('04:30')
    ->withoutOverlapping()
    ->onOneServer();

Schedule::command('vat-changes:notify-subscribers')->dailyAt('05:00')
    ->withoutOverlapping()
    ->onOneServer()
    ->appendOutputTo(storage_path('logs/vat-change-notifications.log'));

$vatAudit = Schedule::command('vat-changes:audit')->weeklyOn(1, '06:00')
    ->withoutOverlapping()
    ->onOneServer()
    ->appendOutputTo(storage_path('logs/vat-audit.log'));

if (filled(config('vat-changes.alert_email'))) {
    $vatChangeImport->emailOutputOnFailure(config('vat-changes.alert_email'));
    $vatAudit->emailOutputOnFailure(config('vat-changes.alert_email'));
}
