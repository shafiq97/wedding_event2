@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Venue[] $events */
    /* @var ?string $noEventsMessage */
    $showVisibility = $showVisibility ?? true;
@endphp

<style>
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
    }
</style>

@if ($events->count() === 0)
    @isset($noEventsMessage)
        <p class="alert alert-danger">
            {{ $noEventsMessage }}
        </p>
    @endisset
@else
    <div class="list-group">
        @foreach ($events as $service)
            @can('view', $service)
                <a href="{{ route('events.show', $service->slug) }}">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="left">
                                <h2 class="card-title">{{ $service->name }}</h2>
                                <p class="card-text">by <a
                                        href="{{ route('landscaper_profile.index', ['user_id' => $service->user_id, 'user_name' => $service->user_name]) }}">{{ $service->user_name }}</a>
                                </p>
                            </div>
                            <div>
                                @for ($i = 0; $i < $service->service_rating; $i++)
                                    <span class="rating-star">&#9733;</span>
                                @endfor
                                @for ($i = $service->service_rating; $i < 5; $i++)
                                    <span class="empty-star">&#9734;</span>
                                @endfor
                            </div>
                            @auth
                                <button style="background: none; border: none;"
                                    class="wishlist-button {{ Auth::user()->wishlist && Auth::user()->wishlist->contains($service->id) ? 'added' : '' }}"
                                    data-service-id="{{ $service->id }}"><i class="fa fa-heart"></i></button>
                            @endauth
                        </div>
                        <div class="card-body">
                            @if ($service->images->count() > 0)
                                <!-- Carousel for images -->
                                <div id="carousel{{ $service->id }}" class="carousel slide mt-2" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @foreach ($service->images as $image)
                                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100"
                                                    alt="Image">
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
                            <!-- Location -->
                            <p class="location-text">
                                <i class="fa fa-fw fa-location-pin location-icon"></i>
                                {{ $service->location->nameOrAddress }}
                            </p>
                            @if ($showVisibility)
                                <div>
                                    <i class="fa fa-fw fa-eye" title="{{ __('Visibility') }}"></i>
                                    <x-badge.visibility :visibility="$service->visibility" />
                                </div>
                            @endif
                            <div class="text-muted">
                                {{ $service->description }}
                            </div>
                            <div class="text-muted">
                                Price from RM{{ $service->min_price }}
                            </div>
                        </div>
                    </div>
                </a>
            @endcan
        @endforeach
    </div>
@endif

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const wishlistButtons = document.querySelectorAll('.wishlist-button');

        wishlistButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const serviceId = this.getAttribute('data-service-id');
                const isAdded = this.classList.contains('added');

                const form = document.createElement('form');
                form.action = isAdded ? '{{ route('wishlist.remove') }}' :
                    '{{ route('wishlist.add') }}';
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
                form.submit();
            });
        });
    });
</script>
