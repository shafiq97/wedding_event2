@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Venue[] $events */
    /* @var ?string $noEventsMessage */
    $showVisibility = $showVisibility ?? true;
@endphp

<style>
    a {
        text-decoration: none;
    }

    .wishlist-button .fa-heart {
        color: black;
    }

    .wishlist-button.added .fa-heart {
        color: red;
    }

    .rating-star {
        color: orange;
    }

    .empty-star {
        color: black;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header .left {
        flex-grow: 1;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }

    .card-header .left .service-info {
        max-width: 60%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

@if ($events->count() === 0)
    @isset($noEventsMessage)
        <p class="alert alert-danger">
            {{ $noEventsMessage }}
        </p>
    @endisset
@else
    <div class="row">
        @foreach ($events as $service)
            @can('view', $service)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">
                                <a href="{{ route('events.show', $service->slug) }}"
                                    class="list-group-item list-group-item-action">{{ $service->name }}</a>
                            </h2>
                            <p class="card-text">by <a
                                    href="{{ route('landscaper_profile.index', ['user_id' => $service->user_id, 'user_name' => $service->user_name]) }}">{{ $service->user_name }}</a>
                            </p>
                        </div>
                        <div class="card-body">
                            @for ($i = 0; $i < $service->service_rating; $i++)
                                <span class="rating-star">&#9733;</span>
                            @endfor
                            @for ($i = $service->service_rating; $i < 5; $i++)
                                <span class="empty-star">&#9734;</span>
                            @endfor
                            <span>{{ number_format($service->service_rating, 1) }}</span>
                            @auth
                                <button style="background: none; border: none;"
                                    class="wishlist-button {{ Auth::user()->wishlist && Auth::user()->wishlist->contains($service->id) ? 'added' : '' }}"
                                    data-service-id="{{ $service->id }}"><i class="fa fa-heart"></i></button>
                            @endauth
                            @if ($service->images->count() > 0)
                                <div id="carousel{{ $service->id }}" class="carousel slide mt-2" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($service->images as $image)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top"
                                                    alt="Image" style="height: 200px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carousel{{ $service->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carousel{{ $service->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            @endif
                            <div class="text-muted" id="description-{{ $service->id }}"></div>
                            <a href="#" id="toggle-{{ $service->id }}"
                                onclick="toggleDescription('{{ $service->id }}')">Read more</a>
                            <div class="text-muted">
                                Price from RM{{ $service->min_price }}
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        @endforeach
    </div>
@endif


<!-- Rest of your JavaScript code... -->


<script>
    // Store all descriptions in an object for easy access
    var descriptions = {
        @foreach ($events as $service)
            "{{ $service->id }}": {!! json_encode($service->description) !!},
        @endforeach
    };

    // This function will be called when the "Read more" or "Show less" link is clicked
    function toggleDescription(serviceId) {
        // Get the elements for the description and the link
        var descriptionElement = document.getElementById('description-' + serviceId);
        var toggleElement = document.getElementById('toggle-' + serviceId);

        // If the short description is currently displayed, switch to the full version
        if (toggleElement.innerHTML === "Read more") {
            descriptionElement.innerHTML = descriptions[serviceId];
            toggleElement.innerHTML = "Show less";
        }
        // If the full description is currently displayed, switch to the short version
        else {
            descriptionElement.innerHTML = descriptions[serviceId].substring(0, 100) + "...";
            toggleElement.innerHTML = "Read more";
        }
    }

    // Insert the initial short descriptions when the page loads
    window.onload = function() {
        for (var serviceId in descriptions) {
            var descriptionElement = document.getElementById('description-' + serviceId);
            var toggleElement = document.getElementById('toggle-' + serviceId);
            descriptionElement.innerHTML = descriptions[serviceId].substring(0, 100) + "...";
            toggleElement.innerHTML = "Read more";
        }
    };


    // Wishlist functionality
    window.addEventListener('DOMContentLoaded', (event) => {
        const wishlistButtons = document.querySelectorAll('.wishlist-button');

        wishlistButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const serviceId = this.getAttribute('data-service-id');
                const isAdded = this.classList.contains('added');

                const form = document.createElement('form');
                form.method = 'POST';
                form.style.display = 'none';

                const csrfToken = document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                const serviceIdInput = document.createElement('input');
                serviceIdInput.type = 'hidden';
                serviceIdInput.name = 'service_id';
                serviceIdInput.value = serviceId;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = isAdded ? 'DELETE' : 'POST';

                form.appendChild(csrfInput);
                form.appendChild(serviceIdInput);
                form.appendChild(methodInput);

                document.body.appendChild(form);

                if (isAdded) {
                    form.action =
                        '{{ route('wishlist.remove', ['wishlist' => ':wishlistId']) }}'
                        .replace(':wishlistId', serviceId);
                } else {
                    form.action = '{{ route('wishlist.add') }}';
                }

                form.submit();
            });
        });
    });
</script>
