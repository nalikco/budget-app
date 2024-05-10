<?php

use App\Actions\MovementCategory\DeleteMovementCategoryAction;
use App\Models\MovementCategory;
use App\Services\MovementCategory\MovementCategoryService;
use Mockery\MockInterface;

it('handle', function () {
    $movementCategory = new MovementCategory();
    $movementCategory->id = 2;

    $this->app->instance(
        MovementCategoryService::class,
        Mockery::mock(MovementCategoryService::class, function (MockInterface $mock) use ($movementCategory) {
            $mock->shouldReceive('delete')
                ->with($movementCategory)
                ->once();
        }),
    );

    $action = $this->app->make(DeleteMovementCategoryAction::class);
    $action->handle($movementCategory);
});
