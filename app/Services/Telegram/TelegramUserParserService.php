<?php

namespace App\Services\Telegram;

use App\Dto\Telegram\TelegramUserDto;
use App\Exceptions\Telegram\InvalidTelegramInitDataException;

class TelegramUserParserService
{
    private string $botToken;

    public function __construct()
    {
        $this->botToken = config('telegram.bot_token');
    }

    /**
     * Get a TelegramUser object from the provided initialization data.
     *
     * @param  string  $initData  The initialization data containing user information.
     * @return TelegramUserDto The TelegramUser object created from the initialization data.
     *
     * @throws InvalidTelegramInitDataException When the initialization data is invalid.
     */
    public function getUserFromInitData(string $initData): TelegramUserDto
    {
        $initDataValues = [];
        parse_str($initData, $initDataValues);

        if (! isset($initDataValues['user'])) {
            throw new InvalidTelegramInitDataException();
        }

        if (! $this->checkInitData($initDataValues)) {
            throw new InvalidTelegramInitDataException();
        }

        $user = json_decode($initDataValues['user'], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidTelegramInitDataException();
        }

        return new TelegramUserDto(
            id: $user['id'],
            firstName: $user['first_name'],
            lastName: $user['last_name'],
            username: $user['username'],
            languageCode: $user['language_code'],
            allowsWriteToPm: $user['allows_write_to_pm'],
        );
    }

    /**
     * Check if the provided initDataValues match the hash value.
     *
     * @param  array  $initDataValues  An array containing data values to be checked.
     * @return bool Returns true if the hash matches the calculated hash from the data values, false otherwise.
     */
    private function checkInitData(array $initDataValues): bool
    {
        $hash = $initDataValues['hash'] ?? null;

        unset($initDataValues['hash']);
        ksort($initDataValues);
        $dataCheckString = implode("\n", array_map(
            function ($n, $v) {
                return "$n=$v";
            },
            array_keys($initDataValues),
            $initDataValues,
        ));

        $secretKey = hash_hmac('sha256', $this->botToken, 'WebAppData', true);
        $key = hash_hmac('sha256', $dataCheckString, $secretKey);

        return $key === $hash;
    }
}
