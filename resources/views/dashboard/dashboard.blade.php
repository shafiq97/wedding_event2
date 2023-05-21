@extends('layouts.app')

@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Venue[] $events */
@endphp


@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Venue[] $events */
    $states = [
        'Johor',
        'Kedah',
        'Kelantan',
        'Melaka',
        'Negeri Sembilan',
        'Pahang',
        'Perak',
        'Perlis',
        'Penang',
        'Sabah',
        'Sarawak',
        'Selangor',
        'Terengganu',
        'Federal Territory of Kuala Lumpur',
        'Federal Territory of Labuan',
        'Federal Territory of Putrajaya',
    ];
@endphp

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('dashboard') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="q"
                        placeholder="{{ __('Search by venues, description and vendor') }}">
                    <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
                </div>

                @foreach ($states as $state)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $state }}" name="states[]" id="{{ $state }}">
                        <label class="form-check-label" for="{{ $state }}">
                            {{ $state }}
                        </label>
                    </div>
                @endforeach
            </form>
        </div>
    <div class="row">
        <div class="col-12 col-md-12">
            <h2>{{ __('My Venue List') }}</h2>
            @include('events.shared.event_list', [
                'events' => $events,
                'showVisibility' => false,
            ])
        </div>
        @if (Auth::user() &&
                null !== Auth::user()->userRoles &&
                count(Auth::user()->userRoles) > 0 &&
                Auth::user()->userRoles[0]->name == 'User' &&
                $bookings !== null)
            {{-- <div class="col-12 col-md-6" style="margin-bottom: 20px">
                <h2>{{ __('My bookings') }}</h2>
                @foreach ($bookings as $booking)
                    @php
                        $service = $booking->bookingOption->event;
                    @endphp
                    <div class="list-group" style="margin-bottom: 20px">
                        <a href="{{ route('bookings.show', $booking) }}" class="list-group-item list-group-item-action">
                            <strong>{{ $service->name }}</strong>
                            <div>
                                <i class="fa fa-fw fa-location-pin"></i>
                                {{ $service->location->nameOrAddress }}
                            </div>
                            <div>
                                <i class="fa fa-fw fa-user-alt"></i>
                                {{ $booking->first_name }} {{ $booking->last_name }}
                            </div>
                            <div>
                                @isset($booking->price)
                                    <span class="badge bg-primary">{{ formatDecimal($booking->price) }}&nbsp;</span>
                                    @isset($booking->paid_at)
                                        <span class="badge bg-primary">{{ __('paid') }}
                                            ({{ $booking->paid_at->isMidnight() ? formatDate($booking->paid_at) : formatDateTime($booking->paid_at) }})
                                        </span>
                                    @else
                                        <span class="badge bg-danger">{{ __('not paid yet') }}</span>
                                    @endisset
                                @else
                                    <span class="badge bg-primary">{{ __('free of charge') }}</span>
                                @endisset
                                @isset($booking->booked_at)
                                    <span class="badge bg-primary">{{ formatDateTime($booking->booked_at) }}</span>
                                @endisset
                            </div>
                        </a>
                    </div>
                    @if ($booking->reviews()->count() > 0)
                        <div class="form-group">
                            <label for="existing_rating">{{ __('Your rating') }}</label>
                            <input disabled type="text" class="form-control" id="existing_rating" name="existing_rating"
                                value="{{ $booking->reviews()->first()->rating }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="existing_comment">{{ __('Your comment') }}</label>
                            <textarea disabled class="form-control" id="existing_comment" name="existing_comment" rows="3" readonly>{{ $booking->reviews()->first()->comment }}</textarea>
                        </div>
                        <hr style="border: 1px red solid">
                    @else
                        @isset($booking->paid_at)
                            <form action="{{ route('reviews.store') }}" method="POST" style="margin-bottom: 20px"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <div class="form-group">
                                    <label for="comment">{{ __('Review') }}</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="rating">{{ __('Rating') }}</label>
                                    <input type="number" class="form-control" id="rating" name="rating" min="1"
                                        max="5" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="image">{{ __('Image') }}</label>
                                    <input type="file" class="form-control-file" id="image" name="image">
                                </div>
                                <div class="form-group" style="margin-top: 10px">
                                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                                </div>
                            </form>

                            <hr style="border: 1px red solid">
                        @endisset
                    @endif
                @endforeach
            </div> --}}
        @endif
    </div>
@endsection
