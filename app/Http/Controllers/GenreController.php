<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use function view;

class GenreController extends Controller
{
    public function index(): View
    {
        return view('genre.index');
    }

    public function show(): View
    {
        return view('genre.show');
    }
}
