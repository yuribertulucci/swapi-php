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


<script>
    function createPagination(totalPages, currentPage, route) {
        const paginationElement = $(`
            <ul class="list-group list-group-horizontal justify-content-end mb-5 mt-3" id="pagination-controls"></ul>
        `);
        const paginationItem = `
            <li class="list-group-item text-warning border-warning" style="cursor: pointer; :hover { background: var(--bs-warning); color: #1a1a1a !important; }">0</li>
        `;

        const prevItem = $(paginationItem);
        prevItem.text('« Prev');
        if (currentPage > 1) {
            prevItem.on('click', function () {
                window.location.href = route + '?page=' + (currentPage - 1);
            });
        } else {
            prevItem.addClass('disabled');
        }
        paginationElement.append(prevItem);

        for (let i = currentPage - 3; i < currentPage; i++) {
            if (i < 1) continue;
            const pageItem = $(paginationItem);
            pageItem.text(i);
            pageItem.on('click', function () {
                window.location.href = route + '?page=' + i;
            });
            paginationElement.append(pageItem);
        }

        const currentItem = $(paginationItem);
        currentItem.text(currentPage);
        currentItem.addClass('bg-warning text-dark');
        paginationElement.append(currentItem);

        for (let i = currentPage + 1; i <= Math.min(currentPage + 2, totalPages); i++) {
            const pageItem = $(paginationItem);
            pageItem.text(i);
            pageItem.on('click', function () {
                window.location.href = route + '?page=' + i;
            });
            paginationElement.append(pageItem);
        }

        const nextItem = $(paginationItem);
        nextItem.text('Next »');
        if (currentPage < totalPages) {
            nextItem.on('click', function () {
                window.location.href = route + '?page=' + (currentPage + 1);
            });
        } else {
            nextItem.addClass('disabled');
        }
        paginationElement.append(nextItem);

        return paginationElement;
    }
</script>

<style>
    .loader {
        width: 48px;
        height: 48px;
        border: 5px solid #FFF;
        border-bottom-color: var(--bs-warning);
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>