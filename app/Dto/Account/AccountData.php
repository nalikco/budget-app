<?php

namespace App\Dto\Account;

use App\Dto\Currency\CurrencyData;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AccountData extends Data
{
    public function __construct(
        public int $id,
        public CurrencyData $currency,
        public string $name,
        public int|float $balance,
        public string $icon,
        #[MapName('created_at')]
        public Carbon $createdAt,
        #[MapName('updated_at')]
        public Carbon $updatedAt,
    ) {
    }
}
