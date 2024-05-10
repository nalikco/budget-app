<?php

namespace App\Dto\User;

use App\Dto\Currency\CurrencyData;
use App\Dto\Telegram\TelegramUserData;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $username,
        public CurrencyData $currency,
        public TelegramUserData $telegramUser,
        #[MapName('created_at')]
        public Carbon $createdAt,
        #[MapName('updated_at')]
        public Carbon $updatedAt,
    ) {
    }
}
