<?php

use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Models\Currency;
use App\Services\Currency\CurrencyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;

uses(RefreshDatabase::class);

it('find by iso code', function () {
    $currency = Currency::factory()->create();
    $service = App::make(CurrencyService::class);

    $foundCurrency = $service->findByIsoCode($currency->iso_code);
    expect($foundCurrency->iso_code)->toBe($currency->iso_code);
});

it('find by iso code: err not found', function () {
    $service = App::make(CurrencyService::class);

    $this->expectException(CurrencyNotFoundException::class);
    $service->findByIsoCode('WRONG');
});
