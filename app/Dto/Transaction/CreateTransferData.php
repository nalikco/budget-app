<?php

namespace App\Dto\Transaction;

use App\Models\Account;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CreateTransferData extends Data
{
    public function __construct(
        public Account $from,
        public Account $to,
        #[MapName('out_amount')]
        public int|float $outAmount,
        #[MapName('in_mount')]
        public int|float $inMount,
    ) {
    }
}
