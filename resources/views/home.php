@extends('layouts.app')

<div class="d-flex text-center flex-column justify-content-center mt-4">
    <h2 class="w-100">Films</h2>
    <div class="row row-cols-3 row-gap-3 my-4" id="films-list">
        <span class="loader mt-5 mx-auto"></span>
        <template id="card-template">
            <div class="col">
                <card class="card">
                    <img src="https://placehold.co/10x10" alt="film-img" class="card-img-top object-fit-cover" style="max-height: 300px;"
                         referrerpolicy="no-referrer">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="card-text"></div>
                        <a href="" class="btn btn-sm btn-info mt-3">See more</a>
                    </div>
                </card>
            </div>
        </template>
    </div>
</div>

<style>
    .card-text {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 7;
        overflow: hidden;
    }
</style>

<script>
    $.ajax('{{ route("api.films.index") }}', {
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
            filmCard.find('.card-text').text(film.opening_crawl);
            filmCard.find('img').attr('src', 'https://placehold.co/500x200/000000/FFFFFF/?text=' + episodeNumberToRoman(film.episode_id));
            filmCard.find('a').attr('href', film.page_url);
            $(filmsList).append(filmCard);
        });
    });
</script>
