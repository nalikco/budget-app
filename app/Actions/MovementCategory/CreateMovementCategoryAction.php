<?php

namespace App\Actions\MovementCategory;

use App\Dto\MovementCategory\CreateMovementCategoryData;
use App\Models\MovementCategory;
use App\Models\User;
use App\Services\MovementCategory\MovementCategoryService;

class CreateMovementCategoryAction
{
    public function __construct(
        private readonly MovementCategoryService $movementCategoryService,
    ) {
    }

    /**
     * Handles the creation of a new movement category for a given user.
     *
     * @param  User  $user  The user for whom the movement category is being created.
     * @param  CreateMovementCategoryData  $data  The data for creating the movement category.
     * @return MovementCategory The newly created movement category.
     */
    public function handle(User $user, CreateMovementCategoryData $data): MovementCategory
    {
        // some events or logs maybe in future

        return $this->movementCategoryService->create($user, $data);
    }
}
