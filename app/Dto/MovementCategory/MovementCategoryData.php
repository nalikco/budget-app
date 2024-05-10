<?php

namespace App\Dto\MovementCategory;

use App\Enums\MovementCategoryType;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class MovementCategoryData extends Data
{
    public function __construct(
        public int $id,
        #[MapName('is_default')]
        public bool $isDefault,
        public MovementCategoryType $type,
        public string $name,
        public string $icon,
        #[MapName('created_at')]
        public Carbon $createdAt,
        #[MapName('updated_at')]
        public Carbon $updatedAt,
    ) {
    }
}
