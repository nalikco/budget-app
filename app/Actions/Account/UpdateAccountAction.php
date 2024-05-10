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
     * @throws CurrencyNotFoundException
     */
    public function handle(Account $account, CreateAccountData $data): Account
    {
        // some events or logs maybe in future

        return $this->accountService->update($account, $data);
    }
}
