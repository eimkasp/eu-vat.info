<?php

use App\Models\Country;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('returns a successful response on the home page', function () {
    Country::factory()->create();

    $this->get('/')
        ->assertSuccessful();
});
