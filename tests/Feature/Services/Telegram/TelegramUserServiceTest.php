<?php

use App\Dto\Telegram\TelegramUserDto;
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
    $telegramUserDto = new TelegramUserDto(
        id: 1,
        firstName: 'John',
        lastName: 'Doe',
        username: 'john.doe',
        languageCode: 'en',
        allowsWriteToPm: true,
    );
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
        ->and($createdUser->telegramUser->first_name)->toBe($telegramUserDto->firstName)
        ->and($createdUser->telegramUser->last_name)->toBe($telegramUserDto->lastName)
        ->and($createdUser->telegramUser->username)->toBe($telegramUserDto->username)
        ->and($createdUser->telegramUser->language_code)->toBe($telegramUserDto->languageCode)
        ->and($createdUser->telegramUser->allows_write_to_pm)->toBe($telegramUserDto->allowsWriteToPm);

});

it('get or create (get)', function () use ($initData) {
    $user = User::factory()->create();
    $telegramUser = TelegramUser::factory()->create(['user_id' => $user->id]);

    $telegramUserDto = new TelegramUserDto(
        id: $telegramUser->telegram_id,
        firstName: $telegramUser->first_name,
        lastName: $telegramUser->last_name,
        username: $telegramUser->username,
        languageCode: $telegramUser->language_code,
        allowsWriteToPm: $telegramUser->allows_write_to_pm,
    );

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
