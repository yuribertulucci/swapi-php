@extends('layouts.app')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0" id="specie-name">
                        <span class="spinner-border spinner-border-sm" role="status"></span> Loading...
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="specie-image" src="https://placehold.co/300x400/1a1a1a/FFFFFF"
                                 alt="Specie" class="img-fluid rounded" referrerpolicy="no-referrer">
                        </div>
                        <div class="col-md-8">
                            <h5 class="border-bottom pb-2 mb-3">Physical Characteristics</h5>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Classification:</strong></div>
                                <div class="col-6" id="classification">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Average Height:</strong></div>
                                <div class="col-6" id="average-height">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Average Lifespan:</strong></div>
                                <div class="col-6" id="average-lifespan">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Eye Colors:</strong></div>
                                <div class="col-6" id="eye-colors">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Hair Colors:</strong></div>
                                <div class="col-6" id="hair-colors">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Skin Colors:</strong></div>
                                <div class="col-6" id="skin-colors">-</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6"><strong>Language:</strong></div>
                                <div class="col-6" id="language">-</div>
                            </div>

                            <h5 class="border-bottom pb-2 mb-3 mt-4">Related Content</h5>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Homeworld:</strong></div>
                                <div class="col-12" id="homeworld">Loading...</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Characters:</strong></div>
                                <div class="col-12" id="characters">Loading...</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12"><strong>Films:</strong></div>
                                <div class="col-12" id="films">Loading...</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('species.index') }}" class="btn btn-warning">← Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const apiUrl = '{{ route("api.species.show", ["id" => "$id"]) }}'

    $.ajax(apiUrl, {
        method: 'GET',
        dataType: 'json',
        async: true
    }).then(function (specie) {
        $('#specie-name').text(specie.name);
        $('#classification').text(specie.classification);
        $('#average-height').text(specie.average_height + ' cm');
        $('#average-lifespan').text(specie.average_lifespan + ' years');
        $('#eye-colors').text(specie.eye_colors);
        $('#hair-colors').text(specie.hair_colors);
        $('#skin-colors').text(specie.skin_colors);
        $('#language').text(specie.language);
        $('#specie-image').attr('src', 'https://placehold.co/300x400/1a1a1a/FFFFFF/?text=' + encodeURIComponent(specie.name));

        if (specie.homeworld) {
            $.ajax(specie.homeworld, {
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

        if (specie.people && specie.people.length > 0) {
            const charactersPromises = specie.people.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(charactersPromises).then(function (charactersList) {
                const charactersBadges = charactersList.map(characters => `<span class="badge bg-primary text-light me-1 mb-1"><a href="${characters?.page_url}" class="link-light link-underline-opacity-0 link-underline-opacity-75-hover">${characters.name}</a></span>`).join('');
                $('#characters').html(charactersBadges);
            }).catch(function () {
                $('#characters').text('Unable to load characters');
            });
        } else {
            $('#characters').text('Unknown');
        }

        if (specie.films && specie.films.length > 0) {
            const filmsPromises = specie.films.map(url => $.ajax(url, { method: 'GET', dataType: 'json' }));
            Promise.all(filmsPromises).then(function (filmsList) {
                const filmsBadges = filmsList.map(films => `<span class="badge bg-warning text-dark me-1 mb-1"><a href="${films?.page_url}" class="link-dark link-underline-opacity-0 link-underline-opacity-75-hover">${films.title}</a></span>`).join('');
                $('#films').html(filmsBadges);
            }).catch(function () {
                $('#films').text('Unable to load films');
            });
        } else {
            $('#films').text('Unknown');
        }
    }).catch(function () {
        $('#character-name').text('Error loading character');
        alert('Failed to load character details. Please try again.');
    });
</script>
