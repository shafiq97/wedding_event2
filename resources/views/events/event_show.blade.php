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
    <x-nav.breadcrumb/>
@endsection

@section('headline-buttons')
    @can('update', $service)
        <x-button.edit href="{{ route('events.edit', $service) }}"/>
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
            <a class="link-light"
               href="{{ route('events.show', $service->parentEvent) }}">{{ $service->parentEvent->name }}</a>
        </span>
    @endisset

    <div class="row my-3">
        <div class="col-12 col-md-4">
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

            @if($service->subEvents->count() > 0 || Auth::user()?->can('createChild', $service))
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
    <x-text.updated-human-diff :model="$service"/>
@endsection
