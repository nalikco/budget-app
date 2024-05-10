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
     * Handles the account creation process.
     *
     * @param  User  $user  The user for whom the account is being created.
     * @param  CreateAccountData  $data  The data needed to create the account.
     * @return Account The newly created account.
     *
     * @throws CurrencyNotFoundException If the specified currency is not found.
     */
    public function handle(User $user, CreateAccountData $data): Account
    {
        // some events or logs maybe in future

        return $this->accountService->create($user, $data);
    }
}
