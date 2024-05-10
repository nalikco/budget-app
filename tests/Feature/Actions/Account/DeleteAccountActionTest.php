<?php

use App\Actions\Account\DeleteAccountAction;
use App\Models\Account;
use App\Services\Account\AccountService;
use Mockery\MockInterface;

it('handle', function () {
    $account = new Account();
    $account->id = 2;

    $this->app->instance(
        AccountService::class,
        Mockery::mock(AccountService::class, function (MockInterface $mock) use ($account) {
            $mock->shouldReceive('delete')
                ->with($account)
                ->once();
        }),
    );

    $action = $this->app->make(DeleteAccountAction::class);
    $action->handle($account);
});
