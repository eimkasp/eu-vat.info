<?php

namespace App\Filament\Widgets;

use App\Models\CountryAnalytic;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CountryStatsChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Analytics Over Time';

    protected function getData(): array
    {
        $data = CountryAnalytic::query()
            ->selectRaw('DATE(created_at) as date, type, COUNT(*) as count')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date', 'type')
            ->get();

        $dates = $data->pluck('date')->unique()->sort()->values();

        $datasets = $data->pluck('type')->unique()->values()->map(fn (string $type) => [
            'label' => ucfirst($type),
            'data' => $dates->map(fn ($date) => (int) ($data->where('date', $date)->where('type', $type)->first()?->count ?? 0))->all(),
        ])->all();

        return [
            'labels' => $dates->map(fn ($date) => Carbon::parse($date)->format('M d'))->all(),
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
