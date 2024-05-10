<?php

use App\Actions\MovementCategory\UpdateMovementCategoryAction;
use App\Dto\MovementCategory\CreateMovementCategoryData;
use App\Enums\MovementCategoryType;
use App\Models\MovementCategory;
use App\Services\MovementCategory\MovementCategoryService;
use Mockery\MockInterface;

it('handle', function () {
    $movementCategory = new MovementCategory();
    $movementCategory->id = 2;
    $data = CreateMovementCategoryData::from([
        'type' => MovementCategoryType::INCOME,
        'name' => 'Visa',
        'icon' => 'visa',
    ]);

    $this->app->instance(
        MovementCategoryService::class,
        Mockery::mock(MovementCategoryService::class, function (MockInterface $mock) use ($data, $movementCategory) {
            $mock->shouldReceive('update')
                ->with($movementCategory, $data)
                ->once()
                ->andReturn($movementCategory);
        }),
    );

    $action = $this->app->make(UpdateMovementCategoryAction::class);
    $updatedMovementCategory = $action->handle($movementCategory, $data);

    expect($updatedMovementCategory)->toBeInstanceOf(MovementCategory::class);
});
