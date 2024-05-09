<?php

use App\Exceptions\Telegram\InvalidTelegramInitDataException;
use App\Services\Telegram\TelegramUserParserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

$token = 'a3c8f1bd39c3666a18a92a8d290dc167d71be95e2df899a4b30526a48b9b0a67';
$initData = 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A3453455%2C%22first_name%22%3A%22John%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=a572c00d30c1407ec9d7357241b1558c6ec5fcc41cffe6484d0efca54423511b';

it('get user from init data', function () use ($token, $initData) {
    Config::set('telegram.bot_token', $token);

    $telegramUserParserService = App::make(TelegramUserParserService::class);

    $result = $telegramUserParserService->getUserFromInitData($initData);

    $this->assertEquals(3453455, $result->id);
    $this->assertEquals('John', $result->firstName);
    $this->assertEquals('Doe', $result->lastName);
    $this->assertEquals('johndoe', $result->username);
    $this->assertEquals('en', $result->languageCode);
    $this->assertTrue($result->allowsWriteToPm);
});

it('get user from init data err: invalid token', function () use ($initData) {
    Config::set('telegram.bot_token', 'invalid');

    $telegramUserParserService = App::make(TelegramUserParserService::class);

    $this->expectException(InvalidTelegramInitDataException::class);
    $telegramUserParserService->getUserFromInitData($initData);
});

it('get user from init data err: invalid hash', function () use ($token) {
    $initData = 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A3453455%2C%22first_name%22%3A%22John%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=a572c00d30c1407ec9d7357241b558c6ec5fcc41cffe6484d0efca54423511b';

    Config::set('telegram.bot_token', $token);

    $telegramUserParserService = App::make(TelegramUserParserService::class);

    $this->expectException(InvalidTelegramInitDataException::class);
    $telegramUserParserService->getUserFromInitData($initData);
});

it('get user from init data err: invalid struct', function () use ($token) {
    $initData = 'auth_date=1712603287&query_id=QoCJwq2LEOltYeZ0&user=%7B%22id%22%3A3453455%2C%22first_name%22%3A%22Joh%22%2C%22last_name%22%3A%22Doe%22%2C%22username%22%3A%22johndoe%22%2C%22language_code%22%3A%22en%22%2C%22allows_write_to_pm%22%3Atrue%7D&hash=a572c00d30c1407ec9d7357241b1558c6ec5fcc41cffe6484d0efca54423511b';

    Config::set('telegram.bot_token', $token);

    $telegramUserParserService = App::make(TelegramUserParserService::class);

    $this->expectException(InvalidTelegramInitDataException::class);
    $telegramUserParserService->getUserFromInitData($initData);
});
