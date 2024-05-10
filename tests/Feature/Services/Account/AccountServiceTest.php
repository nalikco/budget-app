<?php

use App\Dto\Account\CreateAccountData;
use App\Models\Account;
use App\Models\Currency;
use App\Models\User;
use App\Services\Account\AccountService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('create', function () {
    $currency = Currency::factory()->create();
    $user = User::factory()->create();
    $service = $this->app->make(AccountService::class);

    $data = CreateAccountData::from([
        'currency' => $currency->iso_code,
        'name' => 'Visa',
        'balance' => 500,
        'icon' => 'visa',
    ]);

    $createdAccount = $service->create($user, CreateAccountData::from($data));

    expect($user->accounts()->count())->toBe(1)
        ->and($createdAccount)->toBeInstanceOf(Account::class)
        ->and($createdAccount->currency->iso_code)->toBe($data->currency)
        ->and($createdAccount->name)->toBe($data->name)
        ->and($createdAccount->balance)->toBe($data->balance)
        ->and($createdAccount->icon)->toBe($data->icon);
});

it('update', function () {
    $currency = Currency::factory()->create([
        'iso_code' => 'USD',
    ]);
    $account = Account::factory()->create([
        'currency_id' => $currency->id,
    ]);
    $newCurrency = Currency::factory()->create([
        'iso_code' => 'BYN',
    ]);
    $service = $this->app->make(AccountService::class);

    $data = CreateAccountData::from([
        'currency' => $newCurrency->iso_code,
        'name' => 'Visa',
        'balance' => 500,
        'icon' => 'visa',
    ]);

    $updatedAccount = $service->update($account, CreateAccountData::from($data));

    expect($updatedAccount)->toBeInstanceOf(Account::class)
        ->and($updatedAccount->currency->iso_code)->toBe($data->currency)
        ->and($updatedAccount->name)->toBe($data->name)
        ->and($updatedAccount->balance)->toBe($data->balance)
        ->and($updatedAccount->icon)->toBe($data->icon);
});

it('delete', function () {
    $user = User::factory()->create();
    $account = Account::factory()->create([
        'user_id' => $user->id,
    ]);
    $service = $this->app->make(AccountService::class);

    $service->delete($account);
    expect($user->accounts()->count())->toBe(0);
});
