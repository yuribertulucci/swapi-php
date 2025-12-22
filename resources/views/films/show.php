@extends('layouts.app')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0" id="film-title">
                        <span class="spinner-border spinner-border-sm" role="status"></span> Loading...
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="film-image" src="https://placehold.co/400x600/1a1a1a/FFFFFF"
                                 alt="Film Poster" class="img-fluid rounded shadow" referrerpolicy="no-referrer">
                        </div>
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3">Film Information</h5>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Episode:</strong></div>
                                <div class="col-8" id="episode">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Director:</strong></div>
                                <div class="col-8" id="director">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Producer:</strong></div>
                                <div class="col-8" id="producer">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Release Date:</strong></div>
                                <div class="col-8" id="release-date">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4"><strong>Age:</strong></div>
                                <div class="col-8" id="age">-</div>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4">Opening Crawl</h5>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <p id="opening-crawl" class="text-justify fst-italic">Loading...</p>
                                </div>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4">Related Content</h5>
                            <div class="row mb-3">
                                <div class="col-12"><strong>Characters:</strong></div>
                                <div class="col-12" id="characters">Loading...</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12"><strong>Planets:</strong></div>
                                <div class="col-12" id="planets">Loading...</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12"><strong>Starships:</strong></div>
                                <div class="col-12" id="starships">Loading...</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12"><strong>Vehicles:</strong></div>
                                <div class="col-12" id="vehicles">Loading...</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Species:</strong></div>
                                <div class="col-12" id="species">Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('films.index') }}" class="btn btn-warning">← Back to Films</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const filmId = window.location.pathname.split('/').pop();
    const apiUrl = '{{ route("api.films.show", ["id" => "$id"]) }}'.replace('$id', filmId);

    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (film) {
        $('#film-title').text(film.title);
        $('#episode').text('Episode ' + film.episode_id);
        $('#director').text(film.director);
        $('#producer').text(film.producer);
        $('#release-date').text(new Date(film.release_date).toLocaleDateString('en-US'));
        $('#age').text(film.age);
        $('#opening-crawl').text(film.opening_crawl);
        $('#film-image').attr('src', 'https://placehold.co/400x600/1a1a1a/FFFFFF/?text=' + encodeURIComponent(film.title));

        if (film.characters && film.characters.length > 0) {
            const characterPromises = film.characters.map(url => $.ajax(url, {method: 'GET', dataType: 'json'}));
            Promise.all(characterPromises).then(function (characters) {
                const characterBadges = characters.map(character =>
                    `<span class="badge bg-primary me-1 mb-1"><a href="${character?.page_url}" class="link-light link-underline-opacity-0 link-underline-opacity-75-hover">${character.name}</a></span>`
                ).join('');
                $('#characters').html(characterBadges);
            }).catch(function () {
                $('#characters').text('Unable to load characters');
            });
        } else {
            $('#characters').text('None');
        }

        if (film.planets && film.planets.length > 0) {
            const planetPromises = film.planets.map(url => $.ajax(url, {method: 'GET', dataType: 'json'}));
            Promise.all(planetPromises).then(function (planets) {
                const planetBadges = planets.map(planet =>
                    `<span class="badge bg-success me-1 mb-1"><a href="${planet?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${planet.name}</a></span>`
                ).join('');
                $('#planets').html(planetBadges);
            }).catch(function () {
                $('#planets').text('Unable to load planets');
            });
        } else {
            $('#planets').text('None');
        }

        if (film.starships && film.starships.length > 0) {
            const starshipPromises = film.starships.map(url => $.ajax(url, {method: 'GET', dataType: 'json'}));
            Promise.all(starshipPromises).then(function (starships) {
                const starshipBadges = starships.map(ship =>
                    `<span class="badge bg-info text-dark me-1 mb-1"><a href="${ship?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${ship.name}</a></span>`
                ).join('');
                $('#starships').html(starshipBadges);
            }).catch(function () {
                $('#starships').text('Unable to load starships');
            });
        } else {
            $('#starships').text('None');
        }

        if (film.vehicles && film.vehicles.length > 0) {
            const vehiclePromises = film.vehicles.map(url => $.ajax(url, {method: 'GET', dataType: 'json'}));
            Promise.all(vehiclePromises).then(function (vehicles) {
                const vehicleBadges = vehicles.map(vehicle =>
                    `<span class="badge bg-secondary me-1 mb-1"><a href="${vehicle?.page_url}" class="link-warning link-underline-opacity-0 link-underline-opacity-75-hover">${vehicle.name}</a></span>`
                ).join('');
                $('#vehicles').html(vehicleBadges);
            }).catch(function () {
                $('#vehicles').text('Unable to load vehicles');
            });
        } else {
            $('#vehicles').text('None');
        }

        if (film.species && film.species.length > 0) {
            const speciesPromises = film.species.map(url => $.ajax(url, {method: 'GET', dataType: 'json'}));
            Promise.all(speciesPromises).then(function (speciesList) {
                const speciesBadges = speciesList.map(species =>
                    `<span class="badge bg-warning text-dark me-1 mb-1"><a href="${species?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${species.name}</a></span>`
                ).join('');
                $('#species').html(speciesBadges);
            }).catch(function () {
                $('#species').text('Unable to load species');
            });
        } else {
            $('#species').text('None');
        }
    }).catch(function () {
        $('#film-title').text('Error loading film');
        alert('Failed to load film details. Please try again.');
    });
</script>