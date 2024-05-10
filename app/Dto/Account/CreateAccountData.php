<?php

namespace App\Dto\Account;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CreateAccountData extends Data
{
    public function __construct(
        public string $currency,
        public string $name,
        public int|float $balance,
        public string $icon,
    ) {
    }
}
