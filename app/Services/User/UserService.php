<?php

namespace App\Services\User;

use App\Models\Currency;
use App\Models\User;
use App\Services\MovementCategory\MovementCategoryService;

class UserService
{
    public function __construct(
        private readonly MovementCategoryService $movementCategoryService,
    ) {
    }

    /**
     * Create a new user with the specified username and currency.
     *
     * @param  string  $username  The username for the new user.
     * @param  Currency  $currency  The currency to associate with the user.
     * @return User The newly created user.
     */
    public function create(string $username, Currency $currency): User
    {
        $user = User::query()->create([
            'currency_id' => $currency->id,
            'username' => $username,
        ]);
        $this->movementCategoryService->createDefaults($user);

        return $user;
    }
}
