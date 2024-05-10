<?php

use App\Dto\MovementCategory\CreateMovementCategoryData;
use App\Enums\MovementCategoryType;
use App\Models\MovementCategory;
use App\Models\User;
use App\Services\MovementCategory\MovementCategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('create', function () {
    $user = User::factory()->create();
    $data = CreateMovementCategoryData::from([
        'type' => MovementCategoryType::INCOME,
        'name' => 'Transport',
        'icon' => 'taxi',
    ]);
    $service = $this->app->make(MovementCategoryService::class);

    $createdMovementCategory = $service->create($user, $data);

    expect($user->movementCategories()->count())->toBe(1)
        ->and($createdMovementCategory)->toBeInstanceOf(MovementCategory::class)
        ->and($createdMovementCategory->type)->toBe($data->type)
        ->and($createdMovementCategory->name)->toBe($data->name)
        ->and($createdMovementCategory->icon)->toBe($data->icon);
});

it('update', function () {
    $movementCategory = MovementCategory::factory()->create();
    $data = CreateMovementCategoryData::from([
        'type' => MovementCategoryType::INCOME,
        'name' => 'Transport',
        'icon' => 'taxi',
    ]);
    $service = $this->app->make(MovementCategoryService::class);

    $updatedMovementCategory = $service->update($movementCategory, $data);

    expect($updatedMovementCategory)->toBeInstanceOf(MovementCategory::class)
        ->and($updatedMovementCategory->type)->toBe($data->type)
        ->and($updatedMovementCategory->name)->toBe($data->name)
        ->and($updatedMovementCategory->icon)->toBe($data->icon);
});

it('can\'t update default movement category', function () {
    $movementCategory = MovementCategory::factory()->create([
        'is_default' => true,
    ]);
    $data = CreateMovementCategoryData::from([
        'type' => MovementCategoryType::INCOME,
        'name' => 'Transport',
        'icon' => 'taxi',
    ]);
    $service = $this->app->make(MovementCategoryService::class);

    $updatedMovementCategory = $service->update($movementCategory, $data);

    expect($updatedMovementCategory)->toBeInstanceOf(MovementCategory::class)
        ->and($updatedMovementCategory->type)->toBe($movementCategory->type)
        ->and($updatedMovementCategory->name)->toBe($movementCategory->name)
        ->and($updatedMovementCategory->icon)->toBe($movementCategory->icon);
});

it('delete', function () {
    $user = User::factory()->create();
    $movementCategory = MovementCategory::factory()->create([
        'user_id' => $user->id,
    ]);
    $service = $this->app->make(MovementCategoryService::class);

    $service->delete($movementCategory);

    expect($user->movementCategories()->count())->toBe(0);
});

it('can\'t delete default movement category', function () {
    $user = User::factory()->create();
    $movementCategory = MovementCategory::factory()->create([
        'is_default' => true,
        'user_id' => $user->id,
    ]);
    $service = $this->app->make(MovementCategoryService::class);

    $service->delete($movementCategory);

    expect($user->movementCategories()->count())->toBe(1);
});

it('create defaults', function () {
    $user = User::factory()->create();
    $service = $this->app->make(MovementCategoryService::class);

    $defaultMovementCategories = $service->createDefaults($user);

    expect($defaultMovementCategories->count())->toBe(2)
        ->and($user->movementCategories()->count())->toBe(2)
        ->and($user->movementCategories()
            ->where(['type' => MovementCategoryType::INCOME, 'is_default' => true])
            ->first())->not()->toBeNull()
        ->and($user->movementCategories()
            ->where(['type' => MovementCategoryType::OUTCOME, 'is_default' => true])
            ->first())->not()->toBeNull();
});
