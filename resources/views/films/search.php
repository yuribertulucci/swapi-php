@extends('layouts.app')

<div class="d-flex text-center flex-column justify-content-center mt-4">
    <h2 class="w-100">Films</h2>
    <form class="row w-100 justify-content-center" method="GET" action="{{ route('films.search') }}">
        <label for="search-input" class="visually-hidden">Search</label>
        <div class="input-group-append w-50 d-flex justify-content-center gap-2">
            <input type="text" id="search-input" name="query" placeholder="Search films..." class="form-control" value="{{ request()->getQuery('query', '') }}" />
            <button id="search-button" type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <div class="row row-cols-3 row-gap-4 my-4 justify-content-center" id="films-list">
        <span class="loader mt-5 mx-auto"></span>
        <template id="card-template">
            <div class="col">
                <div class="card h-100">
                    <img src="https://placehold.co/500x300/1a1a1a/FFFFFF" alt="film-img"
                         class="card-img-top object-fit-cover" style="max-height: 300px;"
                         referrerpolicy="no-referrer">
                    <div class="card-body d-grid">
                        <h5 class="card-title"></h5>
                        <div class="card-text">
                            <p class="mb-1"><strong>Director(s):</strong> <span class="director"></span></p>
                            <p class="mb-1"><strong>Producer(s):</strong> <span class="producer"></span></p>
                            <p class="mb-1"><strong>Release Date:</strong> <span class="release-date"></span></p>
                            <p class="mb-1"><strong>Age:</strong> <span class="age"></span></p>
                        </div>
                        <div class="d-flex justify-content-center align-items-end">
                            <a href="" class="btn btn-sm btn-info mt-3">Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <div id="pagination">

    </div>
</div>

<style>
    .card-text {
        font-size: 0.9rem;
        text-align: left;
    }
</style>

<script>
    const apiUrl = '{{ route("api.films.index") }}' + '?page=' + '{{ request()->getQuery("page", 1) }}' + '&query=' + encodeURIComponent('{{ request()->getQuery("query", "") }}');
    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (response) {
        const films = response.results;
        const template = $('#card-template').html();
        const filmsList = $('#films-list');

        $('.loader').remove();

        films.forEach(function (film) {
            const filmCard = $(template);
            filmCard.find('.card-title').text(film.title);
            filmCard.find('.director').text(film.director);
            filmCard.find('.producer').text(film.producer);
            filmCard.find('.release-date').text(film.release_date);
            filmCard.find('.age').text(film.age);
            filmCard.find('img').attr('src', 'https://placehold.co/500x300/1a1a1a/FFFFFF/?text=' + encodeURIComponent(film.title + ' - ' + episodeNumberToRoman(film.episode_id)));
            filmCard.find('a').attr('href', film.page_url);
            $(filmsList).append(filmCard);
        });

        const totalPages = response.pages;
        const currentPage = response.current_page;

        const result = createPagination(totalPages, currentPage, '{{ route("films.index") }}');
        $('#pagination').append(result);
    });
</script>