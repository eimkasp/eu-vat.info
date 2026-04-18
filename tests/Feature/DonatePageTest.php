<?php

// ── GET /donate ─────────────────────────────────────────────────────────────

it('renders the donate page', function () {
    $this->get('/donate')
        ->assertSuccessful()
        ->assertSee('Support EU VAT Info')
        ->assertSee('x402');
});

it('has correct SEO meta on donate page', function () {
    $this->get('/donate')
        ->assertSuccessful()
        ->assertSee('Donate — Support EU VAT Info', false)
        ->assertSee('meta name="description"', false);
});

it('shows x402 agent payment section', function () {
    $this->get('/donate')
        ->assertSuccessful()
        ->assertSee('x402 Agent Payment')
        ->assertSee('/api/x402/donate')
        ->assertSee('PAYMENT-REQUIRED');
});

it('shows GitHub Sponsors section', function () {
    $this->get('/donate')
        ->assertSuccessful()
        ->assertSee('GitHub Sponsors')
        ->assertSee('github.com/sponsors/eimkasp');
});

it('shows premium API endpoints with pricing', function () {
    $this->get('/donate')
        ->assertSuccessful()
        ->assertSee('$0.10')
        ->assertSee('$0.01')
        ->assertSee('$0.005');
});

it('shows x402 discovery endpoint', function () {
    $this->get('/donate')
        ->assertSuccessful()
        ->assertSee('/api/x402/info');
});

it('renders donate page with locale prefix', function () {
    $this->get('/de/donate')
        ->assertSuccessful()
        ->assertSee('Support EU VAT Info');
});

it('includes donate link in footer', function () {
    $this->get('/')
        ->assertSuccessful()
        ->assertSee('href="' . locale_path('/donate') . '"', false);
});
