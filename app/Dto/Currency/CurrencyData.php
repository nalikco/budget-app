<?php

namespace App\Dto\Currency;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CurrencyData extends Data
{
    public function __construct(
        public string $iso_code,
        public string $name,
        public string $format,
    ) {
    }
}
