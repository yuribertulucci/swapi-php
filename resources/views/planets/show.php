@extends('layouts.app')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0" id="planet-name">
                        <span class="spinner-border spinner-border-sm" role="status"></span> Loading...
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="planet-image" src="https://placehold.co/300x400/1a1a1a/FFFFFF"
                                 alt="Planet" class="img-fluid rounded" referrerpolicy="no-referrer">
                        </div>
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3">Planet Information</h5>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Diameter:</strong></div>
                                <div class="col-6" id="diameter">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Rotation Period:</strong></div>
                                <div class="col-6" id="rotation-period">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Orbital Period:</strong></div>
                                <div class="col-6" id="orbital-period">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Gravity:</strong></div>
                                <div class="col-6" id="gravity">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Population:</strong></div>
                                <div class="col-6" id="population">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Climate:</strong></div>
                                <div class="col-6" id="climate">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Terrain:</strong></div>
                                <div class="col-6" id="terrain">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Surface Water:</strong></div>
                                <div class="col-6" id="surface-water">-</div>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4">Related Content</h5>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Residents:</strong></div>
                                <div class="col-12" id="residents">Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('planets.index') }}" class="btn btn-warning">← Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const apiUrl = '{{ route("api.planets.show", ["id" => "$id"]) }}'

    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (planet) {
        $('#planet-name').text(planet.name);
        $('#diameter').text(planet.diameter);
        $('#rotation-period').text(planet.rotation_period + ' hours');
        $('#orbital-period').text(planet.orbital_period + ' days');
        $('#gravity').text(planet.gravity);
        $('#population').text(Intl.NumberFormat('en-US').format(planet.population) !== 'NaN' ? Intl.NumberFormat('en-US').format(planet.population) : planet.population);
        $('#climate').text(planet.climate);
        $('#terrain').text(planet.terrain);
        $('#surface-water').text(planet.surface_water + ' %');
        $('#planet-image').attr('src', 'https://placehold.co/300x400/1a1a1a/FFFFFF/?text=' + encodeURIComponent(planet.name));

        if (planet.residents && planet.residents.length > 0) {
            const residentPromises = planet.residents.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(residentPromises).then(function (residents) {
                const residentList = residents.map(resident => `<span class="badge bg-secondary me-1 mb-1"><a href="${resident?.page_url}" class="link-warning link-underline-opacity-0 link-underline-opacity-75-hover">${resident.name}</a></span>`).join('');
                $('#residents').html(residentList);
            }).catch(function () {
                $('#residents').text('Unable to load residents');
            });
        } else {
            $('#residents').text('None');
        }
    }).catch(function () {
        $('#planet-name').text('Error loading planet');
        alert('Failed to load planet details. Please try again.');
    });
</script>
