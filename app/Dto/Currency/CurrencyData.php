<?php

namespace App\Dto\Currency;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CurrencyData extends Data
{
    public function __construct(
        #[MapName('iso_code')]
        public string $isoCode,
        public string $name,
        public string $format,
    ) {
    }
}
