<?php

use App\Actions\MovementCategory\CreateMovementCategoryAction;
use App\Dto\MovementCategory\CreateMovementCategoryData;
use App\Enums\MovementCategoryType;
use App\Models\MovementCategory;
use App\Models\User;
use App\Services\MovementCategory\MovementCategoryService;
use Mockery\MockInterface;

it('handle', function () {
    $movementCategory = new MovementCategory();
    $movementCategory->id = 2;
    $user = new User();
    $user->id = 1;
    $data = CreateMovementCategoryData::from([
        'type' => MovementCategoryType::DEBIT,
        'name' => 'Visa',
        'icon' => 'visa',
    ]);

    $this->app->instance(
        MovementCategoryService::class,
        Mockery::mock(MovementCategoryService::class, function (MockInterface $mock) use ($user, $data, $movementCategory) {
            $mock->shouldReceive('create')
                ->with($user, $data)
                ->once()
                ->andReturn($movementCategory);
        }),
    );

    $action = $this->app->make(CreateMovementCategoryAction::class);
    $createdMovementCategory = $action->handle($user, $data);

    expect($createdMovementCategory)->toBeInstanceOf(MovementCategory::class);
});
