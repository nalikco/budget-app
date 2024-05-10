<?php

namespace App\Dto\Transaction;

use App\Models\Account;
use App\Models\MovementCategory;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CreateTransactionData extends Data
{
    public function __construct(
        public Account $account,
        #[MapName('movement_category')]
        public MovementCategory $movementCategory,
        #[MapName('out_amount')]
        public int|float $outAmount,
        #[MapName('in_amount')]
        public int|float $inAmount,
        public Carbon $date,
        public ?string $description,
    ) {
    }
}
