@extends('layouts.app')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0" id="vehicle-name">
                        <span class="spinner-border spinner-border-sm" role="status"></span> Loading...
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="vehicle-image" src="https://placehold.co/300x400/1a1a1a/FFFFFF"
                                 alt="Vehicle" class="img-fluid rounded" referrerpolicy="no-referrer">
                        </div>
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3">Vehicle Information</h5>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Model:</strong></div>
                                <div class="col-6" id="model">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Vehicle Class:</strong></div>
                                <div class="col-6" id="vehicle-class">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Manufacturer:</strong></div>
                                <div class="col-6" id="manufacturer">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Length:</strong></div>
                                <div class="col-6" id="length">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Cost in Credits:</strong></div>
                                <div class="col-6" id="cost-in-credits">-</div>
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
                    <a href="{{ route('vehicles.index') }}" class="btn btn-warning">← Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const apiUrl = '{{ route("api.vehicles.show", ["id" => "$id"]) }}';

    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (vehicle) {
        $('#vehicle-name').text(vehicle.name);
        $('#model').text(vehicle.model);
        $('#vehicle-class').text(vehicle.vehicle_class);
        $('#manufacturer').text(vehicle.manufacturer);
        $('#length').text(vehicle.length !== 'unknown' ? Intl.NumberFormat('en-US').format(vehicle.length) + ' m' : vehicle.length);
        $('#cost-in-credits').text(Intl.NumberFormat('en-US').format(vehicle.cost_in_credits) !== 'NaN' ? Intl.NumberFormat('en-US').format(vehicle.cost_in_credits) + ' credits' : vehicle.cost_in_credits);
        $('#crew').text(Intl.NumberFormat('en-US').format(vehicle.crew.replaceAll(',', '')) !== 'NaN' ? Intl.NumberFormat('en-US').format(vehicle.crew.replaceAll(',', '')) : vehicle.crew);
        $('#passengers').text(Intl.NumberFormat('en-US').format(vehicle.passengers.replaceAll(',', '')) !== 'NaN' ? Intl.NumberFormat('en-US').format(vehicle.passengers.replaceAll(',', '')) : vehicle.passengers);
        $('#max-atmosphering-speed').text(vehicle.max_atmosphering_speed !== 'unknown' ? Intl.NumberFormat('en-US').format(vehicle.max_atmosphering_speed.replaceAll(',', '')) + ' km/h' : vehicle.max_atmosphering_speed);
        $('#cargo-capacity').text(Intl.NumberFormat('en-US').format(vehicle.cargo_capacity.replaceAll(',', '')) !== 'NaN' ? Intl.NumberFormat('en-US').format(vehicle.cargo_capacity.replaceAll(',', '')) + ' kg' : vehicle.cargo_capacity);
        $('#consumables').text(vehicle.consumables);
        $('#vehicle-image').attr('src', 'https://placehold.co/300x400/1a1a1a/FFFFFF/?text=' + encodeURIComponent(vehicle.name));

        if (vehicle.films && vehicle.films.length > 0) {
            const filmPromises = vehicle.films.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(filmPromises).then(function (films) {
                const filmList = films.map(film => `<span class="badge bg-warning text-dark me-1 mb-1"><a href="${film?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${film.title}</a></span>`).join('');
                $('#films').html(filmList);
            }).catch(function () {
                $('#films').text('Unable to load films');
            });
        } else {
            $('#films').text('None');
        }

        if (vehicle.pilots && vehicle.pilots.length > 0) {
            const pilotsPromises = vehicle.pilots.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(pilotsPromises).then(function (pilotsList) {
                const pilotsBadges = pilotsList.map((pilots) => `<span class="badge bg-primary me-1 mb-1"><a href="${pilots?.page_url}" class="link-light link-underline-opacity-0 link-underline-opacity-75-hover">${pilots.name}</a></span>`).join('');
                $('#pilots').html(pilotsBadges);
            }).catch(function () {
                $('#pilots').text('Unable to load pilots');
            });
        } else {
            $('#pilots').text('Unknown');
        }
    }).catch(function () {
        $('#vehicle-name').text('Error loading vehicle');
        alert('Failed to load vehicle details. Please try again.');
    });
</script>
