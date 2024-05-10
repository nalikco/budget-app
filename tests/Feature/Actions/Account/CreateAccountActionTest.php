<?php

use App\Actions\Account\CreateAccountAction;
use App\Dto\Account\CreateAccountData;
use App\Models\Account;
use App\Models\User;
use App\Services\Account\AccountService;
use Mockery\MockInterface;

it('handle', function () {
    $account = new Account();
    $account->id = 2;
    $user = new User();
    $user->id = 1;
    $data = CreateAccountData::from([
        'currency' => 'BYN',
        'name' => 'Visa',
        'balance' => 500,
        'icon' => 'visa',
    ]);

    $this->app->instance(
        AccountService::class,
        Mockery::mock(AccountService::class, function (MockInterface $mock) use ($user, $data, $account) {
            $mock->shouldReceive('create')
                ->with($user, $data)
                ->once()
                ->andReturn($account);
        }),
    );

    $action = $this->app->make(CreateAccountAction::class);
    $createdAccount = $action->handle($user, $data);

    expect($createdAccount)->toBeInstanceOf(Account::class);
});
