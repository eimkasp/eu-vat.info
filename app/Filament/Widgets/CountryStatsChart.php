<?php

namespace App\Filament\Widgets;

use App\Models\CountryAnalytic;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CountryStatsChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Analytics Over Time';

    protected function getData(): array
    {
        $data = CountryAnalytic::selectRaw('DATE(created_at) as date, type, COUNT(*) as count')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date', 'type')
            ->get();

        $dates = $data->pluck('date')->unique()->sort();
        $types = $data->pluck('type')->unique();

        $datasets = [];
        foreach ($types as $type) {
            $datasets[] = [
                'label' => ucfirst($type),
                'data' => $dates->map(function ($date) use ($data, $type) {
                    return $data->where('date', $date)->where('type', $type)->first()->count ?? 0;
                })->toArray(),
            ];
        }

        return [
            'labels' => $dates->map(fn ($date) => Carbon::parse($date)->format('M d'))->toArray(),
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
