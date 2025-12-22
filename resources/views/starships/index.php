@extends('layouts.app')

<div class="d-flex text-center flex-column justify-content-center mt-4">
    <h2 class="w-100">Starships</h2>
    <div class="row row-cols-3 row-gap-4 my-4 justify-content-center" id="starships-list">
        <span class="loader mt-5 mx-auto"></span>
        <template id="card-template">
            <div class="col">
                <div class="card h-100">
                    <img src="https://placehold.co/500x300/1a1a1a/FFFFFF" alt="starship-img"
                         class="card-img-top object-fit-cover" style="max-height: 300px;"
                         referrerpolicy="no-referrer">
                    <div class="card-body d-grid">
                        <h5 class="card-title"></h5>
                        <div class="card-text">
                            <p class="mb-1"><strong>Model:</strong> <span class="model"></span></p>
                            <p class="mb-1"><strong>Starship Class:</strong> <span class="starship-class"></span></p>
                            <p class="mb-1"><strong>Manufacturer:</strong> <span class="manufacturer"></span></p>
                            <p class="mb-1"><strong>Cost in Credits:</strong> <span class="cost-in-credits"></span></p>
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
    const apiUrl = '{{ route("api.starships.index") }}' + '?page=' + '{{ request()->getQuery("page", 1) }}';
    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (response) {
        const starships = response.results;
        const template = $('#card-template').html();
        const starshipsList = $('#starships-list');

        $('.loader').remove();

        starships.forEach(function (starship) {
            const starshipCard = $(template);
            starshipCard.find('.card-title').text(starship.name);
            starshipCard.find('.model').text(starship.model);
            starshipCard.find('.starship-class').text(starship.starship_class);
            starshipCard.find('.manufacturer').text(starship.manufacturer);
            starshipCard.find('.cost-in-credits').text(Intl.NumberFormat('en-US').format(starship.cost_in_credits) !== 'NaN' ? Intl.NumberFormat('en-US').format(starship.cost_in_credits) + ' credits' : starship.cost_in_credits);
            starshipCard.find('img').attr('src', 'https://placehold.co/500x300/1a1a1a/FFFFFF/?text=' + encodeURIComponent(starship.name));
            starshipCard.find('a').attr('href', starship.page_url);
            $(starshipsList).append(starshipCard);
        });

        const totalPages = response.pages;
        const currentPage = response.current_page;

        const result = createPagination(totalPages, currentPage, '{{ route("starships.index") }}');
        $('#pagination').append(result);
    });
</script>