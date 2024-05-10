<?php

namespace App\Dto\Telegram;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TelegramUserData extends Data
{
    public function __construct(
        public int $id,
        #[MapName('telegram_id')]
        public int $telegramId,
        #[MapName('first_name')]
        public string $firstName,
        #[MapName('last_name')]
        public string $lastName,
        public string $username,
        #[MapName('language_code')]
        public string $languageCode,
        #[MapName('allows_write_to_pm')]
        public bool $allowsWriteToPm,
    ) {
    }
}
