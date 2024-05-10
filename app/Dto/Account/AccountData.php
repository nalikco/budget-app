<?php

namespace App\Dto\Account;

use App\Dto\Currency\CurrencyData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AccountData extends Data
{
    public function __construct(
        public CurrencyData $currency,
        public string $name,
        public int|float $balance,
        public string $icon,
    ) {
    }
}
