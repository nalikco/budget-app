<?php

use App\Models\User;
use App\Services\User\AuthenticateService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

uses(RefreshDatabase::class);

it('authenticate', function () {
    $user = User::factory()->create();
    $service = App::make(AuthenticateService::class);

    $service->authenticate($user);
    expect(Auth::check())->toBeTrue();
});
