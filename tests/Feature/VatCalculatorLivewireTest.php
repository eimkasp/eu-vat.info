<?php

use App\Livewire\HeroCalculator;
use App\Livewire\VatCalculator;
use App\Models\Country;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Livewire\Livewire;

beforeEach(function () {
    Country::factory()->withRates(19, 7)->create(['name' => 'Germany', 'slug' => 'germany', 'iso_code' => 'DE']);
    Country::factory()->withRates(17, 8)->create(['name' => 'Luxembourg', 'slug' => 'luxembourg', 'iso_code' => 'LU']);
});

it('uses the route slug as the calculator country', function () {
    Livewire::test(VatCalculator::class, ['slug' => 'luxembourg'])
        ->assertSet('slug', 'luxembourg')
        ->assertViewHas('isCountryPage', true)
        ->assertViewHas('country', fn (Country $country) => $country->slug === 'luxembourg')
        ->assertSeeLivewire(HeroCalculator::class);
});

it('renders the generic calculator without a slug', function () {
    Livewire::test(VatCalculator::class)
        ->assertSet('slug', null)
        ->assertViewHas('isCountryPage', false);
});

it('returns not found for unknown or unsupported countries', function (string $slug) {
    Country::factory()->create(['name' => 'Canada', 'slug' => 'canada', 'iso_code' => 'CA', 'standard_rate' => 5, 'is_eu_member' => false]);

    $this->get('/vat-calculator/'.$slug)->assertNotFound();
})->with(['atlantis', 'canada']);

it('locks the country slug against client-side changes', function () {
    Livewire::test(VatCalculator::class, ['slug' => 'germany'])->set('slug', 'luxembourg');
})->throws(CannotUpdateLockedPropertyException::class);

it('prefills the calculator from a shared calculation link', function () {
    $this->get('/vat-calculator/germany?amount=250.5&rate=7&mode=include')
        ->assertOk()
        ->assertSee('&quot;mode&quot;:&quot;include&quot;', false)
        ->assertSee('&quot;amount&quot;:&quot;250.50&quot;', false)
        ->assertSee('&quot;selectedRate&quot;:7', false);
});

it('ignores malformed prefill parameters', function () {
    $this->get('/vat-calculator/germany?amount=abc&rate=x&mode=zzz')
        ->assertOk()
        ->assertSee('&quot;mode&quot;:&quot;exclude&quot;', false)
        ->assertSee('&quot;amount&quot;:&quot;100&quot;', false)
        ->assertSee('&quot;selectedRate&quot;:19', false);
});
