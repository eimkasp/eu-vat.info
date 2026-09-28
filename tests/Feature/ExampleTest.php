<?php

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a successful response on the home page', function () {
    Country::factory()->create();

    $this->get('/')
        ->assertSuccessful();
});
