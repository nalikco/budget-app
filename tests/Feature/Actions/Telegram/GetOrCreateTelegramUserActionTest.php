<?php

use App\Actions\Telegram\GetOrCreateTelegramUserAction;
use App\Models\User;
use App\Services\Telegram\TelegramUserService;
use Illuminate\Support\Facades\App;
use Mockery\MockInterface;

it('handle', function () {
    $initData = 'init_data';

    $user = new User();
    $user->id = 1;

    App::instance(
        TelegramUserService::class,
        Mockery::mock(TelegramUserService::class, function (MockInterface $mock) use ($initData, $user) {
            $mock->shouldReceive('getOrCreate')
                ->with($initData)
                ->once()
                ->andReturn($user);
        }),
    );

    $action = App::make(GetOrCreateTelegramUserAction::class);

    $createdUser = $action->handle($initData);
    expect($createdUser->id)->toBe($user->id);
});
