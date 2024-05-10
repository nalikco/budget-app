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
     * @throws CurrencyNotFoundException
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
     * @throws CurrencyNotFoundException
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

    public function delete(Account $account): void
    {
        $account->delete();
    }
}
