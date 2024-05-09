<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticateService
{
    /**
     * Authenticate the user.
     *
     * @param  User  $user  The user to authenticate.
     */
    public function authenticate(User $user): void
    {
        Auth::login($user, true);
    }
}
