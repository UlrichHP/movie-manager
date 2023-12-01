<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column h-100">
    <div id="app" class="d-flex flex-column h-100">
        <header class="navbar navbar-expand-md navbar-light" style="background-color: #e3f2fd;">
            <nav class="container-xxl flex-wrap flex-md-nowrap" aria-label="Main navigation">
                <a class="navbar-brand p-0 me-2" href="/">Movie Manager</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="bi" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
                    </svg>
                </button>

                <div class="collapse navbar-collapse" id="bdNavbar">
                    <ul class="navbar-nav flex-row flex-wrap flex-grow-1 justify-content-center bd-navbar-nav pt-2 py-md-0">
                        <li class="nav-item col-6 col-md-auto">
                            <a class="nav-link p-2 {{ request()->route()->uri === '/' ? 'active' : '' }}" href="/">Films</a>
                        </li>
                        <li class="nav-item col-6 col-md-auto">
                            <a class="nav-link p-2 {{ request()->route()->uri === 'actors' ? 'active' : '' }}" href="/actors">Acteurs</a>
                        </li>
                        <li class="nav-item col-6 col-md-auto">
                            <a class="nav-link p-2 {{ request()->route()->uri === 'genres' ? 'active' : '' }}" href="/genres">Genres</a>
                        </li>
                    </ul>
                    <div class="col-md-3 text-end">
                        <a href="{{ route('login') }}" type="button" class="btn btn-outline-info me-2 {{ request()->route()->uri === 'login' ? 'active' : '' }}">Se connecter</a>
                        <a href="{{ route('register') }}" type="button" class="btn btn-outline-primary {{ request()->route()->uri === 'register' ? 'active' : '' }}">S'inscrire</a>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="footer mt-auto py-3 bg-light">
            <div class="container text-center">
                <span class="text-muted">© {{ now()->year }} - Movie Manager</span>
            </div>
        </footer>
    </div>
</body>
</html>
