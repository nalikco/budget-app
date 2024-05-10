<?php

use App\Enums\MovementCategoryType;
use App\Exceptions\Account\InsufficientFundsException;
use App\Services\Account\AccountCalculationService;

it('calculate (income)', function () {
    $service = $this->app->make(AccountCalculationService::class);
    $balance = 500;
    $amount = 50;

    $result = $service->calculate($balance, $amount, MovementCategoryType::INCOME);
    expect($result)->toBe($balance + $amount);
});

it('calculate (outcome)', function () {
    $service = $this->app->make(AccountCalculationService::class);
    $balance = 500;
    $amount = 50;

    $result = $service->calculate($balance, $amount, MovementCategoryType::OUTCOME);
    expect($result)->toBe($balance - $amount);
});

it('calculate (outcome): err insufficient funds', function () {
    $service = $this->app->make(AccountCalculationService::class);
    $balance = 0;
    $amount = 50;

    $this->expectException(InsufficientFundsException::class);
    $service->calculate($balance, $amount, MovementCategoryType::OUTCOME);
});

it('rollback (income)', function () {
    $service = $this->app->make(AccountCalculationService::class);
    $balance = 500;
    $amount = 50;

    $result = $service->rollback($balance, $amount, MovementCategoryType::INCOME);
    expect($result)->toBe($balance - $amount);
});

it('rollback (income): err insufficient funds', function () {
    $service = $this->app->make(AccountCalculationService::class);
    $balance = 0;
    $amount = 50;

    $this->expectException(InsufficientFundsException::class);
    $service->rollback($balance, $amount, MovementCategoryType::INCOME);
});

it('rollback (outcome)', function () {
    $service = $this->app->make(AccountCalculationService::class);
    $balance = 500;
    $amount = 50;

    $result = $service->rollback($balance, $amount, MovementCategoryType::OUTCOME);
    expect($result)->toBe($balance + $amount);
});
