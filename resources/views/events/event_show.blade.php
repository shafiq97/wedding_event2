@extends('layouts.app')

@php
    /** @var \App\Models\Venue $service */
@endphp

@section('title')
    {{ $service->name }}
@endsection

@section('breadcrumbs')
    @can('viewAny', \App\Models\Venue::class)
        <x-nav.breadcrumb href="{{ route('events.index') }}">{{ __('Venue') }}</x-nav.breadcrumb>
    @else
        <x-nav.breadcrumb>{{ __('Events') }}</x-nav.breadcrumb>
    @endcan
    <x-nav.breadcrumb />
@endsection

@section('headline-buttons')
    @can('update', $service)
        <x-button.edit href="{{ route('events.edit', $service) }}" />
    @endcan
@endsection

@section('content')
    @isset($service->eventSeries)
        <span class="badge bg-primary">
            <span>
                <i class="fa fa-fw fa-calendar-week"></i>
                {{ __('Part of the venue series') }}
            </span>
            <a class="link-light"
                href="{{ route('event-series.show', $service->eventSeries->slug) }}">{{ $service->eventSeries->name }}</a>
        </span>
    @endisset
    @isset($service->parentEvent)
        <span class="badge bg-primary">
            <span>
                <i class="fa fa-fw fa-calendar-days"></i>
                {{ __('Part of the event') }}
            </span>
            <a class="link-light" href="{{ route('events.show', $service->parentEvent) }}">{{ $service->parentEvent->name }}</a>
        </span>
    @endisset

    <div class="row my-3">
        <div class="col-12 col-md-4">
            @if ($service->images->count() > 0)
                <!-- Carousel for images -->
                <div id="carousel{{ $service->id }}" class="carousel slide mt-2" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($service->images as $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image->path) }}" class="card-img-top" alt="Image"
                                    style="height: 200px; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $service->id }}"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $service->id }}"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @endif
            @include('events.shared.event_details')
        </div>
        <div class="col-12 col-md-8">
            <x-list.group class="mb-3">
                @include('events.shared.event_booking_options')
            </x-list.group>

            @can('create', \App\Models\BookingOption::class)
                <div class="mb-3">
                    <x-button.create href="{{ route('booking-options.create', $service) }}">
                        {{ __('Create booking option') }}
                    </x-button.create>
                </div>
            @endcan

            @if ($service->subEvents->count() > 0 || Auth::user()?->can('createChild', $service))
                @include('events.shared.event_list', [
                    'events' => $service->subEvents,
                ])

                @can('createChild', $service)
                    <div class="mt-3">
                        <x-button.create href="{{ route('events.create', ['parent_event_id' => $service->id]) }}">
                            {{ __('Create Wedding Venue') }}
                        </x-button.create>
                    </div>
                @endcan
            @endif
        </div>
    </div>
    <div style="height: 400px; overflow-y: auto;">
        @foreach ($reviews as $review)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                &#9733;
                                <!-- filled star for each point of the rating -->
                            @else
                                &#9734;
                                <!-- empty star for remaining points -->
                            @endif
                        @endfor
                    </h5>
                    <small>by {{ $review->user->first_name }}</small>
                    <p class="card-text">{{ $review->comment }}</p>
                    @if ($review->image_path)
                        <img height="200px" src="{{ Storage::url($review->image_path) }}" alt="Review Image">
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <x-text.updated-human-diff :model="$service" />
@endsection
