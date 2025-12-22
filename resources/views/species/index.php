@extends('layouts.app')

<div class="d-flex text-center flex-column justify-content-center mt-4">
    <h2 class="w-100">Species</h2>
    <div class="row row-cols-3 row-gap-4 my-4 justify-content-center" id="species-list">
        <span class="loader mt-5 mx-auto"></span>
        <template id="card-template">
            <div class="col">
                <div class="card">
                    <img src="https://placehold.co/500x300/1a1a1a/FFFFFF" alt="specie-img"
                         class="card-img-top object-fit-cover" style="max-height: 300px;"
                         referrerpolicy="no-referrer">
                    <div class="card-body d-grid">
                        <h5 class="card-title"></h5>
                        <div class="card-text">
                            <p class="mb-1"><strong>Classification:</strong> <span class="classification"></span></p>
                            <p class="mb-1"><strong>Average Height:</strong> <span class="average-height"></span> cm</p>
                            <p class="mb-1"><strong>Average Lifespan:</strong> <span class="average-lifespan"></span> years</p>
                            <p class="mb-1"><strong>Language:</strong> <span class="language"></span></p>
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
    const apiUrl = '{{ route("api.species.index") }}' + '?page=' + '{{ request()->getQuery("page", 1) }}';
    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (response) {
        const species = response.results;
        const template = $('#card-template').html();
        const speciesList = $('#species-list');

        $('.loader').remove();

        species.forEach(function (specie) {
            const specieCard = $(template);
            specieCard.find('.card-title').text(specie.name);
            specieCard.find('.classification').text(specie.classification);
            specieCard.find('.average-height').text(specie.average_height);
            specieCard.find('.average-lifespan').text(specie.average_lifespan);
            specieCard.find('.language').text(specie.language);
            specieCard.find('img').attr('src', 'https://placehold.co/500x300/1a1a1a/FFFFFF/?text=' + encodeURIComponent(specie.name));
            specieCard.find('a').attr('href', specie.page_url);
            $(speciesList).append(specieCard);
        });

        const totalPages = response.pages;
        const currentPage = response.current_page;

        const result = createPagination(totalPages, currentPage, '{{ route("species.index") }}');
        $('#pagination').append(result);
    });
</script>