<?php

namespace App\Http\Controllers;

use App\Actions\Telegram\GetOrCreateTelegramUserAction;
use App\Exceptions\Currency\CurrencyNotFoundException;
use App\Exceptions\Telegram\InvalidTelegramInitDataException;
use App\Http\Requests\Telegram\TelegramAuthenticateRequest;
use App\Services\User\AuthenticateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;
use Spatie\RouteAttributes\Attributes\Prefix;

#[Middleware('guest')]
#[Prefix('/authenticate')]
class AuthenticateController extends Controller
{
    public function __construct(
        private readonly GetOrCreateTelegramUserAction $getOrCreateTelegramUserAction,
        private readonly AuthenticateService $authenticateService,
    ) {
    }

    #[Get('/', name: 'login')]
    public function view(): Response
    {
        return Inertia::render('login', [
            'auth.route' => route('authenticate'),
        ]);
    }

    /**
     * Authenticate the user via Telegram.
     */
    #[Post('/', name: 'authenticate')]
    public function authenticate(TelegramAuthenticateRequest $request): RedirectResponse
    {
        try {
            $user = $this->getOrCreateTelegramUserAction->handle($request->init_data);
            $this->authenticateService->authenticate($user);

            return Redirect::route('home');
        } catch (CurrencyNotFoundException) {
            abort(500);
        } catch (InvalidTelegramInitDataException) {
            return redirect()->back()->withErrors([
                'init_data' => 'Invalid Telegram InitData.',
            ]);
        }
    }
}
