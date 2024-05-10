<?php

namespace App\Services\MovementCategory;

use App\Dto\MovementCategory\CreateMovementCategoryData;
use App\Models\MovementCategory;
use App\Models\User;

class MovementCategoryService
{
    /**
     * Creates a new Movement Category for a given User using the provided data.
     *
     * @param  User  $user  The User for whom the Movement Category will be created.
     * @param  CreateMovementCategoryData  $data  The data used to create the Movement Category.
     * @return MovementCategory The newly created Movement Category.
     */
    public function create(User $user, CreateMovementCategoryData $data): MovementCategory
    {
        return $user->movementCategories()
            ->create($data->toArray());
    }

    /**
     * Updates a Movement Category with the provided data.
     *
     * @param  MovementCategory  $movementCategory  The Movement Category to be updated.
     * @param  CreateMovementCategoryData  $data  The data used to update the Movement Category.
     * @return MovementCategory The updated Movement Category.
     */
    public function update(MovementCategory $movementCategory, CreateMovementCategoryData $data): MovementCategory
    {
        $movementCategory->update($data->toArray());

        return $movementCategory;
    }

    /**
     * Deletes a Movement Category.
     *
     * @param  MovementCategory  $movementCategory  The Movement Category to be deleted.
     */
    public function delete(MovementCategory $movementCategory): void
    {
        $movementCategory->delete();
    }
}
