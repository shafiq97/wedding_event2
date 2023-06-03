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
                <div class="row mb-1">
                    <span>{{ $service->name }} by
                        <a
                            href="{{ route('landscaper_profile.index', ['user_id' => $service->user_id, 'user_name' => $service->user_name]) }}">{{ $service->user_name }}</a></span>
                </div>
                <a href="{{ route('events.show', $service->slug) }}" class="list-group-item list-group-item-action"
                    style="margin-bottom: 20px;">
                    <div class="row">
                        <div class="col d-flex justify-content-between align-items-center">
                            <div>
                                @for ($i = 0; $i < $service->service_rating; $i++)
                                    <span>&#9733;</span> <!-- this is a star character -->
                                @endfor
                                @for ($i = $service->service_rating; $i < 5; $i++)
                                    <span>&#9734;</span> <!-- this is an empty star character -->
                                @endfor
                            </div>
                            <button style="background: none; border: none;" class="wishlist-button"
                                data-service-id="{{ $service->id }}"><i class="fa fa-heart"></i></button>
                        </div>
                    </div>
                    @if ($service->images->count() > 0)
                        <div id="carousel{{ $service->id }}" class="carousel slide" data-bs-ride="carousel">
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
                    <div>
                        <i class="fa fa-fw fa-location-pin"></i>
                        {{ $service->location->nameOrAddress }}
                    </div>
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

                if (this.classList.contains('added')) {
                    console.log("Removed from wishlist: " + serviceId);
                    alert("Removed from wishlist");
                    this.classList.remove('added');
                } else {
                    console.log("Added to wishlist: " + serviceId);
                    alert("Added to wishlist");
                    this.classList.add('added');
                }
            });
        });
    });
</script>
