<?php

namespace App\Services\Account;

use App\Dto\Account\CreateAccountData;
use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Models\Account;
use App\Models\User;
use App\Services\Currency\CurrencyService;

class AccountService
{
    public function __construct(
        private readonly CurrencyService $currencyService,
    ) {
    }

    /**
     * Creates an account for the given user.
     *
     * @param  User  $user  The user for whom the account is being created.
     * @param  CreateAccountData  $data  The data for creating the account.
     * @return Account The newly created account.
     *
     * @throws CurrencyNotFoundException If the specified currency code is not found.
     */
    public function create(User $user, CreateAccountData $data): Account
    {
        $currency = $this->currencyService->findByIsoCode($data->currency);

        return $user->accounts()->create([
            'currency_id' => $currency->id,
            ...$data->toArray(),
        ]);
    }

    /**
     * Updates an existing account.
     *
     * @param  Account  $account  The account to be updated.
     * @param  CreateAccountData  $data  The data for updating the account.
     * @return Account The updated account.
     *
     * @throws CurrencyNotFoundException If the specified currency code is not found.
     */
    public function update(Account $account, CreateAccountData $data): Account
    {
        $currency = $this->currencyService->findByIsoCode($data->currency);
        $account->update([
            'currency_id' => $currency->id,
            ...$data->toArray(),
        ]);

        return $account;
    }

    /**
     * Deletes an existing account.
     *
     * @param  Account  $account  The account to be deleted.
     */
    public function delete(Account $account): void
    {
        $account->delete();
    }
}
