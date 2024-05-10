<?php

namespace App\Actions\Account;

use App\Dto\Account\CreateAccountData;
use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Models\Account;
use App\Services\Account\AccountService;

class UpdateAccountAction
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    /**
     * Handles the account update process.
     *
     * @param  Account  $account  The account to be updated.
     * @param  CreateAccountData  $data  The data needed for the account update.
     * @return Account The updated account.
     *
     * @throws CurrencyNotFoundException If the specified currency is not found.
     */
    public function handle(Account $account, CreateAccountData $data): Account
    {
        // some events or logs maybe in future

        return $this->accountService->update($account, $data);
    }
}
