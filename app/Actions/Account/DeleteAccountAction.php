<?php

namespace App\Actions\Account;

use App\Models\Account;
use App\Services\Account\AccountService;

class DeleteAccountAction
{
    public function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    /**
     * Handles the deletion of an account.
     *
     * @param  Account  $account  The account to be deleted.
     */
    public function handle(Account $account): void
    {
        // some events or logs maybe in future

        $this->accountService->delete($account);
    }
}
