<?php

namespace App\Actions\Telegram;

use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Exceptions\Telegram\InvalidTelegramInitDataException;
use App\Models\User;
use App\Services\Telegram\TelegramUserService;

class GetOrCreateTelegramUserAction
{
    public function __construct(
        private readonly TelegramUserService $telegramUserService,
    ) {
    }

    /**
     * Get or create a user based on Telegram initialization data.
     *
     * @param  string  $initData  The initialization data from Telegram.
     * @return User The created or existing user.
     *
     * @throws InvalidTelegramInitDataException If the Telegram initialization data is invalid.
     * @throws CurrencyNotFoundException If the default currency is not found.
     */
    public function handle(string $initData): User
    {
        // some events or logs maybe in future

        return $this->telegramUserService->getOrCreate($initData);
    }
}
