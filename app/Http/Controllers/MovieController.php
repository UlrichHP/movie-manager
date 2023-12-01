<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use function view;

class MovieController extends Controller
{
    public function index(): View
    {
        return view('movie.index');
    }

    public function show(): View
    {
        return view('movie.show');
    }
}
