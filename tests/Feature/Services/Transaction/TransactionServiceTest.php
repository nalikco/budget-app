<?php

use App\Dto\Transaction\CreateTransactionData;
use App\Enums\MovementCategoryType;
use App\Models\Account;
use App\Models\MovementCategory;
use App\Services\Account\AccountCalculationService;
use App\Services\Transaction\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;

uses(RefreshDatabase::class);

it('create', function () {
    $account = Account::factory()->create();
    $movementCategory = MovementCategory::factory()->create([
        'type' => MovementCategoryType::INCOME,
    ]);

    $data = CreateTransactionData::from([
        'account' => $account,
        'movement_category' => $movementCategory,
        'out_amount' => 500,
        'in_amount' => 450,
        'date' => now(),
        'description' => 'Desc',
    ]);

    $this->app->instance(
        AccountCalculationService::class,
        Mockery::mock(AccountCalculationService::class, function (MockInterface $mock) use ($data) {
            $mock->shouldReceive('calculate')
                ->with($data->account->balance, $data->inAmount, $data->movementCategory->type)
                ->once()
                ->andReturn($data->account->balance + $data->inAmount);
        }),
    );
    $service = $this->app->make(TransactionService::class);

    $createdTransaction = $service->create($data);
    expect($account->transactions()->count())->toBe(1)
        ->and($movementCategory->transactions()->count())->toBe(1)
        ->and($createdTransaction->account->id)->toBe($account->id)
        ->and($createdTransaction->movementCategory->id)->toBe($movementCategory->id)
        ->and($createdTransaction->out_amount)->toBe($data->outAmount)
        ->and($createdTransaction->in_amount)->toBe($data->inAmount)
        ->and($createdTransaction->date->toDateTimeString())->toBe($data->date->toDateTimeString())
        ->and($createdTransaction->description)->toBe($data->description);
});
