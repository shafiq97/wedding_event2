@extends('layouts.app')

@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Models\Venue[] $services */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations */
@endphp

@section('title')
    {{ __('Venues') }} by {{ $services_user_name }}
@endsection

@section('breadcrumbs')
    <x-nav.breadcrumb />
@endsection

@section('content')
    <x-button.group>
        @can('create', \App\Models\Venue::class)
            <x-button.create href="{{ route('events.create') }}">
                {{ __('Create Wedding Venue') }}
            </x-button.create>
        @endcan
    </x-button.group>
    {{-- @if (Auth::check() && $chats->isNotEmpty())
        <a href="{{ route('chat.landscaper', ['user_id' => $chats->first()->user_id, 'landscaper_id' => $chats->first()->landscaper_id, 'user_name' => $chats->first()->first_name]) }}"
            class="btn btn-warning">Chat</a>
    @elseif (Auth::check())
        <a href="{{ route('chat.landscaper', ['user_id' => $user_id, 'landscaper_id' => $landscaper_id]) }}"
            class="btn btn-warning">Chat</a>
    @endif --}}

    <h3>Information</h3>
    <h6>
        {{ __('Email') }} : {{ $user_contact_number }}
    </h6>
    <h6>
        Provided Area
        @foreach ($services->unique('location_name') as $service)
            <p>{{ $service->location_name }}</p>
        @endforeach
    </h6>
    {{-- <h3>Reviews</h3>
    @if ($services->count())
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Reviewed by</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        @if ($service->reviews->count())
                            @foreach ($service->reviews as $review)
                                <tr>
                                    <td>{{ $review->rating }} / 5</td>
                                    <td>{{ $review->comment }}</td>
                                    <td>{{ $review->user->first_name }}</td>
                                    <td class="text-align: center;">
                                        <img src="{{ Storage::url($review->image_path) }}" width="200" alt="Image">
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">No review found.</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No services found.</p>
    @endif --}}



    {{-- <x-form.filter method="GET">
        <div class="row">
            <div class="col-12 col-md-6">
                <x-form.row>
                    <x-form.label for="name">{{ __('Name') }}</x-form.label>
                    <x-form.input id="name" name="filter[name]" />
                </x-form.row>
            </div>
            <div class="col-12 col-md-6 col-xl">
                <x-form.row>
                    <x-form.label for="location_id">{{ __('Location') }}</x-form.label>
                    <x-form.select id="location_id" name="filter[location_id]" :options="$locations->pluck('nameOrAddress', 'id')">
                        <option value="">{{ __('all') }}</option>
                    </x-form.select>
                </x-form.row>
            </div>
            <div class="col-12 col-md-6 col-xl">
                <x-form.row>
                    <x-form.label for="organization_id">{{ __('Organization') }}</x-form.label>
                    <x-form.select id="organization_id" name="filter[organization_id]" :options="$organizations->pluck('name', 'id')">
                        <option value="">{{ __('all') }}</option>
                    </x-form.select>
                </x-form.row>
            </div>
        </div>
    </x-form.filter> --}}


    <x-alert.count class="mt-3" :count="$services->total()" />
    <div class="row my-3">
        @foreach ($services as $service)
            <div class="col-12 col-md-6 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <a href="{{ route('events.show', $service->slug) }}">{{ $service->name }}</a>
                        </h2>
                    </div>
                    <x-list.group class="list-group-flush">
                        <x-list.item :flex="false">
                            <i class="fa fa-fw fa-eye" title="{{ __('Visibility') }}"></i>
                            <x-badge.visibility :visibility="$service->visibility" />
                        </x-list.item>
                        {{-- <x-list.item :flex="false">
                            <i class="fa fa-fw fa-clock" title="{{ __('Date') }}"></i>
                            <span class="text-end">@include('events.shared.event_dates')</span>
                        </x-list.item> --}}
                        <x-list.item :flex="false">
                            <i class="fa fa-fw fa-location-pin" title="{{ __('Location') }}"></i>
                            <span class="d-inline-block">
                                <div class="d-flex flex-column">
                                    @foreach ($service->location->fullAddressBlock as $line)
                                        <div>{{ $line }}</div>
                                    @endforeach
                                </div>
                            </span>
                        </x-list.item>
                        <x-list.item>
                            <span>
                                <i class="fa fa-fw fa-sitemap"></i>
                                {{ __('Organizations') }}
                            </span>
                            <div class="text-end">
                                <ul class="list-unstyled">
                                    @foreach ($service->organizations as $organization)
                                        <li>{{ $organization->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </x-list.item>
                        @isset($service->eventSeries)
                            <x-list.item>
                                <span>
                                    <i class="fa fa-fw fa-calendar-week"></i>
                                    {{ __('Part of the venue series') }}
                                </span>
                                <span class="text-end">
                                    <a href="{{ route('event-series.show', $service->eventSeries->slug) }}" target="_blank">
                                        {{ $service->eventSeries->name }}
                                    </a>
                                </span>
                            </x-list.item>
                        @endisset
                        {{-- Display reviews --}}
                        @include('events.shared.event_booking_options')
                    </x-list.group>
                    <div class="card-body">
                        @can('update', $service)
                            <x-button.edit href="{{ route('events.edit', $service) }}" />
                        @endcan

                        @can('create', \App\Models\BookingOption::class)
                            <x-button.create href="{{ route('booking-options.create', $service) }}">
                                {{ __('Create booking option') }}
                            </x-button.create>
                        @endcan
                    </div>
                    <div class="card-footer">
                        <x-text.updated-human-diff :model="$service" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $services->withQueryString()->links() }}
@endsection
