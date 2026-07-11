<?php

namespace App\Livewire;

use App\Models\VatRateChange;
use Livewire\Component;

class VatChangesArchive extends Component
{
    public ?int $year = null;

    public bool $upcoming = false;

    public function mount(?int $year = null, ?string $archiveType = null): void
    {
        $this->year = $year;
        $this->upcoming = $archiveType === 'upcoming';

        if ($this->year !== null) {
            abort_unless($this->year >= 2000 && $this->year <= 2100, 404);
            abort_unless(VatRateChange::query()->whereYear('change_date', $this->year)->exists(), 404);
        }
    }

    public function render()
    {
        $query = VatRateChange::query()
            ->with('country')
            ->whereHas('country', fn ($countryQuery) => $countryQuery->where('is_eu_member', true));

        if ($this->upcoming) {
            $query->whereDate('change_date', '>', today())->orderBy('change_date');
        } else {
            $query->whereYear('change_date', $this->year)->orderByDesc('change_date');
        }

        return view('livewire.vat-changes-archive', [
            'changes' => $query->get(),
        ]);
    }
}
