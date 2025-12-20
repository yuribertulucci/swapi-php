@extends('layouts.app')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0" id="character-name">
                        <span class="spinner-border spinner-border-sm" role="status"></span> Loading...
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="character-image" src="https://placehold.co/300x400/1a1a1a/FFFFFF"
                                 alt="Character" class="img-fluid rounded" referrerpolicy="no-referrer">
                        </div>
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3">Physical Characteristics</h5>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Birth Year:</strong></div>
                                <div class="col-6" id="birth-year">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Gender:</strong></div>
                                <div class="col-6" id="gender">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Height:</strong></div>
                                <div class="col-6" id="height">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Mass:</strong></div>
                                <div class="col-6" id="mass">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Hair Color:</strong></div>
                                <div class="col-6" id="hair-color">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Skin Color:</strong></div>
                                <div class="col-6" id="skin-color">-</div>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4">Additional Information</h5>
                            <div class="row mb-2 align-items-center">
                                <div class="col-12"><strong>Homeworld:</strong></div>
                                <div class="col-12" id="homeworld">Loading...</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Species:</strong></div>
                                <div class="col-12" id="species">Loading...</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Films:</strong></div>
                                <div class="col-12" id="films">Loading...</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Starships:</strong></div>
                                <div class="col-12" id="starships">Loading...</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Vehicles:</strong></div>
                                <div class="col-12" id="vehicles">Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('people.index') }}" class="btn btn-warning">← Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const personId = window.location.pathname.split('/').pop();
    const apiUrl = '{{ route("api.people.show", ["id" => "$id"]) }}'

    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (person) {
        $('#character-name').text(person.name);
        $('#birth-year').text(person.birth_year);
        $('#gender').text(person.gender.charAt(0).toUpperCase() + person.gender.slice(1));
        $('#height').text(person.height + ' cm');
        $('#mass').text(person.mass + ' kg');
        $('#hair-color').text(person.hair_color);
        $('#skin-color').text(person.skin_color);
        $('#character-image').attr('src', 'https://placehold.co/300x400/1a1a1a/FFFFFF/?text=' + encodeURIComponent(person.name));

        if (person.homeworld) {
            $.ajax(person.homeworld, {
                method: 'GET',
                dataType: 'json'
            }).then(function (homeworld) {
                $('#homeworld').html(`<span class="badge bg-light-subtle me-1 mb-1"><a href="${homeworld?.page_url}" class="link-light link-underline-opacity-0 link-underline-opacity-75-hover">${homeworld.name}</a></span>`);
            }).catch(function () {
                $('#homeworld').text('Unknown');
            });
        } else {
            $('#homeworld').text('Unknown');
        }

        if (person.species && person.species.length > 0) {
            const speciesPromises = person.species.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(speciesPromises).then(function (speciesList) {
                const speciesBadges = speciesList.map(species => `<span class="badge bg-success me-1 mb-1"><a href="${species?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${species.name}</a></span>`).join('');
                $('#species').html(speciesBadges);
            }).catch(function () {
                $('#species').text('Unable to load species');
            });
        } else {
            $('#species').text('Unknown');
        }

        if (person.films && person.films.length > 0) {
            const filmPromises = person.films.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(filmPromises).then(function (films) {
                const filmList = films.map(film => `<span class="badge bg-warning text-dark me-1 mb-1"><a href="${film?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${film.title}</a></span>`).join('');
                $('#films').html(filmList);
            }).catch(function () {
                $('#films').text('Unable to load films');
            });
        } else {
            $('#films').text('None');
        }

        if (person.starships && person.starships.length > 0) {
            const starshipPromises = person.starships.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(starshipPromises).then(function (starships) {
                const starshipList = starships.map(ship => `<span class="badge bg-info text-dark me-1 mb-1"><a href="${ship?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${ship.name}</a></span>`).join('');
                $('#starships').html(starshipList);
            }).catch(function () {
                $('#starships').text('Unable to load starships');
            });
        } else {
            $('#starships').text('None');
        }

        if (person.vehicles && person.vehicles.length > 0) {
            const vehiclePromises = person.vehicles.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(vehiclePromises).then(function (vehicles) {
                const vehicleList = vehicles.map(vehicle => `<span class="badge bg-secondary me-1 mb-1"><a href="${vehicle?.page_url}" class="link-warning link-underline-opacity-0 link-underline-opacity-75-hover">${vehicle.name}</a></span>`).join('');
                $('#vehicles').html(vehicleList);
            }).catch(function () {
                $('#vehicles').text('Unable to load vehicles');
            });
        } else {
            $('#vehicles').text('None');
        }
    }).catch(function () {
        $('#character-name').text('Error loading character');
        alert('Failed to load character details. Please try again.');
    });
</script>
