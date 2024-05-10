<?php

namespace App\Dto\Telegram;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class TelegramUserData extends Data
{
    public function __construct(
        public int $id,
        public int $telegram_id,
        public string $first_name,
        public string $last_name,
        public string $username,
        public string $language_code,
        public bool $allows_write_to_pm,
    ) {
    }
}
