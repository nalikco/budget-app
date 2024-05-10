<?php

use App\Dto\Telegram\TelegramUserData;
use App\Exceptions\Telegram\TelegramUserNotFound;
use App\Models\Currency;
use App\Models\TelegramUser;
use App\Models\User;
use App\Services\Currency\CurrencyService;
use App\Services\Telegram\TelegramUserParserService;
use App\Services\Telegram\TelegramUserService;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Mockery\MockInterface;

uses(RefreshDatabase::class);

$initData = 'init_data';

it('get or create (create)', function () use ($initData) {
    $telegramUserDto = TelegramUserData::from([
        'id' => 1,
        'telegram_id' => 1,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'username' => 'john.doe',
        'language_code' => 'en',
        'allows_write_to_pm' => true,
    ]);
    $this->instance(
        TelegramUserParserService::class,
        Mockery::mock(TelegramUserParserService::class, function (MockInterface $mock) use ($initData, $telegramUserDto) {
            $mock->shouldReceive('getUserFromInitData')
                ->with($initData)
                ->once()
                ->andReturn($telegramUserDto);
        }),
    );

    $currency = Currency::factory()->create([
        'iso_code' => TelegramUserService::DEFAULT_CURRENCY,
    ]);
    $this->instance(
        CurrencyService::class,
        Mockery::mock(CurrencyService::class, function (MockInterface $mock) use ($currency) {
            $mock->shouldReceive('findByIsoCode')
                ->with(TelegramUserService::DEFAULT_CURRENCY)
                ->once()
                ->andReturn($currency);
        }),
    );

    $user = User::factory()->create([
        'currency_id' => $currency->id,
    ]);
    $this->instance(
        UserService::class,
        Mockery::mock(UserService::class, function (MockInterface $mock) use ($telegramUserDto, $currency, $user) {
            $mock->shouldReceive('create')
                ->with($telegramUserDto->username, $currency)
                ->once()
                ->andReturn($user);
        }),
    );

    $service = App::make(TelegramUserService::class);
    $createdUser = $service->getOrCreate($initData);

    expect(TelegramUser::query()->count())->toBe(1)
        ->and($createdUser->id)->toBe($user->id)
        ->and($createdUser->currency->iso_code)->toBe(TelegramUserService::DEFAULT_CURRENCY)
        ->and($createdUser->telegramUser->telegram_id)->toBe($telegramUserDto->id)
        ->and($createdUser->telegramUser->first_name)->toBe($telegramUserDto->first_name)
        ->and($createdUser->telegramUser->last_name)->toBe($telegramUserDto->last_name)
        ->and($createdUser->telegramUser->username)->toBe($telegramUserDto->username)
        ->and($createdUser->telegramUser->language_code)->toBe($telegramUserDto->language_code)
        ->and($createdUser->telegramUser->allows_write_to_pm)->toBe($telegramUserDto->allows_write_to_pm);

});

it('get or create (get)', function () use ($initData) {
    $user = User::factory()->create();
    $telegramUser = TelegramUser::factory()->create(['user_id' => $user->id]);

    $telegramUserDto = TelegramUserData::from($telegramUser);
    $this->instance(
        TelegramUserParserService::class,
        Mockery::mock(TelegramUserParserService::class, function (MockInterface $mock) use ($initData, $telegramUserDto) {
            $mock->shouldReceive('getUserFromInitData')
                ->with($initData)
                ->once()
                ->andReturn($telegramUserDto);
        }),
    );

    $service = App::make(TelegramUserService::class);

    $foundUser = $service->getOrCreate($initData);

    expect(TelegramUser::query()->count())->toBe(1)
        ->and($foundUser->id)->toBe($user->id)
        ->and($foundUser->telegramUser->telegram_id)->toBe($user->telegramUser->telegram_id)
        ->and($foundUser->telegramUser->first_name)->toBe($user->telegramUser->first_name)
        ->and($foundUser->telegramUser->last_name)->toBe($user->telegramUser->last_name)
        ->and($foundUser->telegramUser->username)->toBe($user->telegramUser->username)
        ->and($foundUser->telegramUser->language_code)->toBe($user->telegramUser->language_code)
        ->and($foundUser->telegramUser->allows_write_to_pm)->toBe($user->telegramUser->allows_write_to_pm);
});

it('find by telegram id', function () {
    $user = User::factory()->create();
    $telegramUser = TelegramUser::factory()->create(['user_id' => $user->id]);

    $service = App::make(TelegramUserService::class);
    $foundUser = $service->findByTelegramId($telegramUser->telegram_id);

    expect($foundUser->telegram_id)->toBe($telegramUser->telegram_id);
});

it('find by telegram id: err not found', function () {
    $service = App::make(TelegramUserService::class);

    $this->expectException(TelegramUserNotFound::class);
    $service->findByTelegramId(1);
});
