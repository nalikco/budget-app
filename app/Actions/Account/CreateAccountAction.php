<?php

namespace App\Actions\Account;

use App\Dto\Account\CreateAccountData;
use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Models\Account;
use App\Models\User;
use App\Services\Account\AccountService;

class CreateAccountAction
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    /**
     * @throws CurrencyNotFoundException
     */
    public function handle(User $user, CreateAccountData $data): Account
    {
        // some events or logs maybe in future

        return $this->accountService->create($user, $data);
    }
}
