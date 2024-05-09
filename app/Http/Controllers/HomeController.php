<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Middleware('auth')]
class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    #[Get('/', name: 'home')]
    public function index(): Response
    {
        return Inertia::render('home');
    }
}
