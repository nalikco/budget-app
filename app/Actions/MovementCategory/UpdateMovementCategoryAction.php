<?php

namespace App\Actions\MovementCategory;

use App\Dto\MovementCategory\CreateMovementCategoryData;
use App\Models\MovementCategory;
use App\Services\MovementCategory\MovementCategoryService;

class UpdateMovementCategoryAction
{
    public function __construct(
        private readonly MovementCategoryService $movementCategoryService,
    ) {
    }

    /**
     * Handles the update of a movement category using the provided data.
     *
     * @param  MovementCategory  $movementCategory  The movement category to update.
     * @param  CreateMovementCategoryData  $data  The data to update the movement category with.
     * @return MovementCategory The updated movement category.
     */
    public function handle(MovementCategory $movementCategory, CreateMovementCategoryData $data): MovementCategory
    {
        // some events or logs maybe in future

        return $this->movementCategoryService->update($movementCategory, $data);
    }
}
