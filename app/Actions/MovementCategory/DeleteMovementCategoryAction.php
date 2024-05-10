<?php

namespace App\Actions\MovementCategory;

use App\Models\MovementCategory;
use App\Services\MovementCategory\MovementCategoryService;

class DeleteMovementCategoryAction
{
    public function __construct(
        private readonly MovementCategoryService $movementCategoryService,
    ) {
    }

    /**
     * Handle the deletion of a movement category.
     *
     * @param  MovementCategory  $movementCategory  The movement category to be deleted
     */
    public function handle(MovementCategory $movementCategory): void
    {
        // some events or logs maybe in future

        $this->movementCategoryService->delete($movementCategory);
    }
}
