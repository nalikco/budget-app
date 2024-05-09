<?php

namespace App\Services\User;

use App\Models\Currency;
use App\Models\User;

class UserService
{
    /**
     * Create a new user with the specified username and currency.
     *
     * @param string $username The username for the new user.
     * @param Currency $currency The currency to associate with the user.
     *
     * @return User The newly created user.
     */
    public function create(string $username, Currency $currency): User
    {
        return User::query()->create([
            'currency_id' => $currency->id,
            'username' => $username,
        ]);
    }
}
