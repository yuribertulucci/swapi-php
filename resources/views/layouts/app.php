<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StarWars DB</title>

    <!-- Bootstrap CSS and JS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/bootstrap/css/bootstrap.min.css') }}">
    <script type="application/javascript" src="{{ asset('/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- jQuery -->
    <script type="application/javascript" src="{{ asset('/assets/jquery/jquery.min.js') }}"></script>

    <!-- JS Helpers -->
    <script type="application/javascript" src="{{ asset('/assets/js/helpers.js') }}"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/styles.css') }}">
</head>
<body class="min-vh-100" data-bs-theme="dark">
<header class="bg-dark">
    <div class="container navbar w-100">
        <a href="{{ route('home') }}"
           class="link-warning link-underline-opacity-0 link-underline-opacity-75-hover link-offset-3-hover">
            <img style="max-height: 30px;" class="me-2" src="{{ asset('site-icon.png') }}" alt="icon">StarWars DB
        </a>
        <ul class="nav nav-underline">
            <li class="nav-item"><a class="nav-link link-warning" href="{{ route('films.index') }}">Films</a></li>
            <li class="nav-item"><a class="nav-link link-warning" href="{{ route('people.index') }}">People</a></li>
            <li class="nav-item"><a class="nav-link link-warning" href="{{ route('planets.index') }}">Planets</a></li>
            <li class="nav-item"><a class="nav-link link-warning" href="{{ route('species.index') }}">Species</a></li>
            <li class="nav-item"><a class="nav-link link-warning" href="{{ route('starships.index') }}">Starships</a></li>
            <li class="nav-item"><a class="nav-link link-warning" href="{{ route('vehicles.index') }}">Vehicles</a></li>
        </ul>
    </div>
</header>
<main class="container" style="min-height: 100%">
    {{ $slot }}
</main>
</body>
</html>
