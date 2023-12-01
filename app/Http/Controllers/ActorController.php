<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use function view;

class ActorController extends Controller
{
    public function index(): View
    {
        return view('actor.index');
    }

    public function show(): View
    {
        return view('actor.show');
    }
}
