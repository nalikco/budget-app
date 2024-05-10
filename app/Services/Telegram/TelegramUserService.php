<?php

namespace App\Services\Telegram;

use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Exceptions\Telegram\InvalidTelegramInitDataException;
use App\Exceptions\Telegram\TelegramUserNotFound;
use App\Models\TelegramUser;
use App\Models\User;
use App\Services\Currency\CurrencyService;
use App\Services\User\UserService;

class TelegramUserService
{
    public const string DEFAULT_CURRENCY = 'BYN';

    public function __construct(
        private readonly UserService $userService,
        private readonly CurrencyService $currencyService,
        private readonly TelegramUserParserService $telegramUserParserService,
    ) {
    }

    /**
     * Retrieves a user by Telegram Init Data or creates a new one.
     *
     * @param  string  $initData  The Telegram Init Data.
     * @return User The found or created user.
     *
     * @throws InvalidTelegramInitDataException
     * @throws CurrencyNotFoundException
     */
    public function getOrCreate(string $initData): User
    {
        $telegramUserData = $this->telegramUserParserService->getUserFromInitData($initData);

        try {
            return $this->findByTelegramId($telegramUserData->telegramId)->user;
        } catch (TelegramUserNotFound) {
            $user = $this->userService->create(
                username: $telegramUserData->username,
                currency: $this->currencyService->findByIsoCode(self::DEFAULT_CURRENCY),
            );
            $user->telegramUser()
                ->create($telegramUserData->toArray());

            return $user;
        }
    }

    /**
     * Find a Telegram user by their Telegram ID.
     *
     * @param  int  $telegramId  The Telegram ID of the user to find.
     * @return TelegramUser The found Telegram user.
     *
     * @throws TelegramUserNotFound If the specified Telegram user is not found.
     */
    public function findByTelegramId(int $telegramId): TelegramUser
    {
        $telegramUser = TelegramUser::query()
            ->where('telegram_id', $telegramId)
            ->first();
        if (is_null($telegramUser)) {
            throw new TelegramUserNotFound();
        }

        return $telegramUser;
    }
}
