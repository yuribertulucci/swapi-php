@extends('layouts.app')

<div class="d-flex text-center flex-column justify-content-center mt-4">
    <h2 class="w-100">Planets</h2>
    <div class="row row-cols-3 row-gap-4 my-4 justify-content-center" id="planets-list">
        <span class="loader mt-5 mx-auto"></span>
        <template id="card-template">
            <div class="col">
                <div class="card h-100">
                    <img src="https://placehold.co/500x300/1a1a1a/FFFFFF" alt="planet-img"
                         class="card-img-top object-fit-cover" style="max-height: 300px;"
                         referrerpolicy="no-referrer">
                    <div class="card-body d-grid">
                        <h5 class="card-title"></h5>
                        <div class="card-text">
                            <p class="mb-1"><strong>Diameter:</strong> <span class="diameter"></span> km</p>
                            <p class="mb-1"><strong>Gravity:</strong> <span class="gravity"></span></p>
                            <p class="mb-1"><strong>Population:</strong> <span class="population"></span></p>
                            <p class="mb-1"><strong>Climate:</strong> <span class="climate"></span></p>
                            <p class="mb-1"><strong>Terrain:</strong> <span class="terrain"></span></p>
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
    const apiUrl = '{{ route("api.planets.index") }}' + '?page=' + '{{ request()->getQuery("page", 1) }}';
    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (response) {
        const planets = response.results;
        const template = $('#card-template').html();
        const planetsList = $('#planets-list');

        $('.loader').remove();

        planets.forEach(function (planet) {
            const planetCard = $(template);
            planetCard.find('.card-title').text(planet.name);
            planetCard.find('.diameter').text(planet.diameter);
            planetCard.find('.gravity').text(planet.gravity);
            planetCard.find('.population').text(planet.population);
            planetCard.find('.climate').text(planet.climate);
            planetCard.find('.terrain').text(planet.terrain);
            planetCard.find('img').attr('src', 'https://placehold.co/500x300/1a1a1a/FFFFFF/?text=' + encodeURIComponent(planet.name));
            planetCard.find('a').attr('href', planet.page_url);
            $(planetsList).append(planetCard);
        });

        const totalPages = response.pages;
        const currentPage = response.current_page;

        const result = createPagination(totalPages, currentPage, '{{ route("planets.index") }}');
        $('#pagination').append(result);
    });
</script>