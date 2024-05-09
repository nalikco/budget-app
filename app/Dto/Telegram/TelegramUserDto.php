<?php

namespace App\Dto\Telegram;

class TelegramUserDto
{
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public string $username,
        public string $languageCode,
        public bool $allowsWriteToPm,
    ) {
    }

    public function toArray(): array
    {
        return [
            'telegram_id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'username' => $this->username,
            'language_code' => $this->languageCode,
            'allows_write_to_pm' => $this->allowsWriteToPm,
        ];
    }
}
