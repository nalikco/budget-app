<?php

use App\Models\Currency;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;

uses(RefreshDatabase::class);

it('create', function () {
    $username = '';
    $currency = Currency::factory()->create();
    $service = App::make(UserService::class);

    $createdUser = $service->create($username, $currency);
    expect(User::query()->count())->toBe(1)
        ->and($createdUser->username)->toBe($username)
        ->and($createdUser->currency->iso_code)->toBe($currency->iso_code);
});
