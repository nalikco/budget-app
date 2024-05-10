<?php

namespace App\Dto\MovementCategory;

use App\Enums\MovementCategoryType;
use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MovementCategoryData extends Data
{
    public function __construct(
        public int $id,
        public MovementCategoryType $type,
        public string $name,
        public string $icon,
        public Carbon $created_at,
        public Carbon $updated_at,
    ) {
    }
}
