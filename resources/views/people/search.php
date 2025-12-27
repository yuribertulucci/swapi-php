@extends('layouts.app')

<div class="d-flex text-center flex-column justify-content-center mt-4">
    <h2 class="w-100">Characters search results:</h2>
    <form class="row w-100 justify-content-center my-4" method="GET" action="{{ route('people.search') }}">
        <label for="search-input" class="visually-hidden">Search</label>
        <div class="input-group-append w-50 d-flex justify-content-center gap-2">
            <input type="text" id="search-input" name="query" placeholder="Search characters..." class="form-control" value="{{ request()->getQuery('query', '') }}" />
            <button id="search-button" type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    <div class="row row-cols-3 row-gap-4 my-4 justify-content-center" id="people-list">
        <span class="loader mt-5 mx-auto"></span>
        <template id="card-template">
            <div class="col">
                <div class="card h-100">
                    <img src="https://placehold.co/500x300/1a1a1a/FFFFFF" alt="character-img"
                         class="card-img-top object-fit-cover" style="max-height: 300px;"
                         referrerpolicy="no-referrer">
                    <div class="card-body d-grid">
                        <h5 class="card-title"></h5>
                        <div class="card-text">
                            <p class="mb-1"><strong>Birth Year:</strong> <span class="birth-year"></span></p>
                            <p class="mb-1"><strong>Gender:</strong> <span class="gender"></span></p>
                            <p class="mb-1"><strong>Height:</strong> <span class="height"></span> cm</p>
                            <p class="mb-1"><strong>Mass:</strong> <span class="mass"></span> kg</p>
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


<script>
    const apiUrl = '{{ route("api.people.search") }}' + '?page=' + '{{ request()->getQuery("page", 1) }}' + '&query=' + encodeURIComponent('{{ request()->getQuery("query", "") }}');
    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (response) {
        const people = response.results;
        const template = $('#card-template').html();
        const peopleList = $('#people-list');

        $('.loader').remove();

        people.forEach(function (person) {
            const personCard = $(template);
            personCard.find('.card-title').text(person.name);
            personCard.find('.birth-year').text(person.birth_year);
            personCard.find('.gender').text(person.gender);
            personCard.find('.height').text(person.height);
            personCard.find('.mass').text(person.mass);
            personCard.find('img').attr('src', 'https://placehold.co/500x300/1a1a1a/FFFFFF/?text=' + encodeURIComponent(person.name));
            personCard.find('a').attr('href', person.page_url);
            $(peopleList).append(personCard);
        });

        const totalPages = response.pages;
        const currentPage = response.current_page;

        const result = createPagination(totalPages, currentPage, '{{ route("people.index") }}');
        $('#pagination').append(result);
    });
</script>

