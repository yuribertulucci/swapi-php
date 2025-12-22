@extends('layouts.app')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0" id="starship-name">
                        <span class="spinner-border spinner-border-sm" role="status"></span> Loading...
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="starship-image" src="https://placehold.co/300x400/1a1a1a/FFFFFF"
                                 alt="Starship" class="img-fluid rounded" referrerpolicy="no-referrer">
                        </div>
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3">Starship Information</h5>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Model:</strong></div>
                                <div class="col-6" id="model">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Starship Class:</strong></div>
                                <div class="col-6" id="starship-class">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Manufacturer:</strong></div>
                                <div class="col-6" id="manufacturer">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Cost in Credits:</strong></div>
                                <div class="col-6" id="cost-in-credits">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Length:</strong></div>
                                <div class="col-6" id="length">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Crew:</strong></div>
                                <div class="col-6" id="crew">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Passengers:</strong></div>
                                <div class="col-6" id="passengers">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Max Atmosphering Speed:</strong></div>
                                <div class="col-6" id="max-atmosphering-speed">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Hyperdrive Rating:</strong></div>
                                <div class="col-6" id="hyperdrive-rating">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>MGLT:</strong></div>
                                <div class="col-6" id="mglt">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Cargo Capacity:</strong></div>
                                <div class="col-6" id="cargo-capacity">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Consumables:</strong></div>
                                <div class="col-6" id="consumables">-</div>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4">Additional Information</h5>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Films:</strong></div>
                                <div class="col-12" id="films">Loading...</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Pilots:</strong></div>
                                <div class="col-12" id="pilots">Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('starships.index') }}" class="btn btn-warning">← Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const apiUrl = '{{ route("api.starships.show", ["id" => "$id"]) }}'

    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (starship) {
        $('#starship-name').text(starship.name);
        $('#model').text(starship.model);
        $('#starship-class').text(starship.starship_class);
        $('#manufacturer').text(starship.manufacturer);
        $('#cost-in-credits').text(Intl.NumberFormat('en-US').format(starship.cost_in_credits) !== 'NaN' ? Intl.NumberFormat('en-US').format(starship.cost_in_credits) + ' credits' : starship.cost_in_credits);
        $('#length').text(Intl.NumberFormat('en-US').format(starship?.length.replaceAll(',', '')) !== 'NaN' ? Intl.NumberFormat('en-US').format(starship?.length.replaceAll(',', '')) + ' m' : starship.length);
        $('#crew').text(Intl.NumberFormat('en-US').format(starship?.crew.replaceAll(',', '')) !== 'NaN' ? Intl.NumberFormat('en-US').format(starship?.crew.replaceAll(',', '')) : starship.crew);
        $('#passengers').text(Intl.NumberFormat('en-US').format(starship?.passengers.replaceAll(',', '')) !== 'NaN' ? Intl.NumberFormat('en-US').format(starship?.passengers.replaceAll(',', '')) : starship.passengers);
        $('#max-atmosphering-speed').text(Intl.NumberFormat('en-US').format(starship.max_atmosphering_speed) !== 'NaN' ? Intl.NumberFormat('en-US').format(starship.max_atmosphering_speed) + ' km/h' : starship.max_atmosphering_speed);
        $('#hyperdrive-rating').text(starship.hyperdrive_rating);
        $('#mglt').text(starship.mglt);
        $('#cargo-capacity').text(Intl.NumberFormat('en-US').format(starship.cargo_capacity) !== 'NaN' ? Intl.NumberFormat('en-US').format(starship.cargo_capacity) + ' kg' : starship.cargo_capacity);
        $('#consumables').text(starship.consumables);
        $('#starship-image').attr('src', 'https://placehold.co/300x400/1a1a1a/FFFFFF/?text=' + encodeURIComponent(starship.name));

        if (starship.homeworld) {
            $.ajax(starship.homeworld, {
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

        if (starship.films && starship.films.length > 0) {
            const filmPromises = starship.films.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(filmPromises).then(function (films) {
                const filmList = films.map(film => `<span class="badge bg-warning text-dark me-1 mb-1"><a href="${film?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${film.title}</a></span>`).join('');
                $('#films').html(filmList);
            }).catch(function () {
                $('#films').text('Unable to load films');
            });
        } else {
            $('#films').text('None');
        }

        if (starship.pilots && starship.pilots.length > 0) {
            const pilotsPromises = starship.pilots.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(pilotsPromises).then(function (pilotsList) {
                const pilotsBadges = pilotsList.map(pilots => `<span class="badge bg-primary me-1 mb-1"><a href="${pilots?.page_url}" class="link-light link-underline-opacity-0 link-underline-opacity-75-hover">${pilots.name}</a></span>`).join('');
                $('#pilots').html(pilotsBadges);
            }).catch(function () {
                $('#pilots').text('Unable to load pilots');
            });
        } else {
            $('#pilots').text('Unknown');
        }
    }).catch(function () {
        $('#starship-name').text('Error loading starship');
        alert('Failed to load starship details. Please try again.');
    });
</script>
