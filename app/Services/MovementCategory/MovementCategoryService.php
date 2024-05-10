<?php

namespace App\Services\MovementCategory;

use App\Dto\MovementCategory\CreateMovementCategoryData;
use App\Enums\MovementCategoryType;
use App\Models\MovementCategory;
use App\Models\User;
use Illuminate\Support\Collection;

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
        if ($movementCategory->is_default) {
            return $movementCategory;
        }

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
        if ($movementCategory->is_default) {
            return;
        }

        $movementCategory->delete();
    }

    /**
     * Creates default movement categories for a given user.
     *
     * @param  User  $user  The user for whom the default movement categories will be created.
     * @return Collection The collection of created default movement categories.
     */
    public function createDefaults(User $user): Collection
    {
        $transferDefaults = [
            'is_default' => true,
            'name' => MovementCategory::TRANSFER_CATEGORY_NAME,
            'icon' => MovementCategory::TRANSFER_CATEGORY_ICON,
        ];

        return $user->movementCategories()
            ->createMany([
                ['type' => MovementCategoryType::INCOME, ...$transferDefaults],
                ['type' => MovementCategoryType::OUTCOME, ...$transferDefaults],
            ]);
    }
}
