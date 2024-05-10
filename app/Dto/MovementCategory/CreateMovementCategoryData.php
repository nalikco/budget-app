<?php

namespace App\Dto\MovementCategory;

use App\Enums\MovementCategoryType;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CreateMovementCategoryData extends Data
{
    public function __construct(
        public MovementCategoryType $type,
        public string $name,
        public string $icon,
    ) {
    }
}
