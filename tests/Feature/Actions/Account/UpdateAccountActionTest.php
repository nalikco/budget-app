<?php

use App\Actions\Account\UpdateAccountAction;
use App\Dto\Account\CreateAccountData;
use App\Models\Account;
use App\Services\Account\AccountService;
use Mockery\MockInterface;

it('handle', function () {
    $account = new Account();
    $account->id = 2;
    $data = CreateAccountData::from([
        'currency' => 'BYN',
        'name' => 'Visa',
        'balance' => 500,
        'icon' => 'visa',
    ]);

    $this->app->instance(
        AccountService::class,
        Mockery::mock(AccountService::class, function (MockInterface $mock) use ($data, $account) {
            $mock->shouldReceive('update')
                ->with($account, $data)
                ->once()
                ->andReturn($account);
        }),
    );

    $action = $this->app->make(UpdateAccountAction::class);
    $updatedAccount = $action->handle($account, $data);

    expect($updatedAccount)->toBeInstanceOf(Account::class);
});
