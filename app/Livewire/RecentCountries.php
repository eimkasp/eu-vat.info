<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;

class RecentCountries extends Component
{
    public $recentCountries = [];

    public function mount()
    {
        $recentIds = session()->get('recent_countries', []);

        if (empty($recentIds)) {
            $this->recentCountries = collect([]);

            return;
        }

        // Convert stored IDs to Country models
        $this->recentCountries = Country::whereIn('id', $recentIds)
            ->when(count($recentIds) > 0, function ($query) use ($recentIds) {
                return $query->orderByRaw('FIELD(id,'.implode(',', array_filter($recentIds)).')');
            })
            ->limit(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.recent-countries');
    }
}
