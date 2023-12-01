<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use function view;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function register(): View
    {
        return view('auth.register');
    }
}
