@extends('layouts.app')

@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Venue[] $events */
@endphp

@section('title')
    {{ __('Homepage') }}
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
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2>{{ __('My bookings') }}</h2>
            <div class="row">
                @foreach ($bookings as $booking)
                    @php
                        $service = $booking->bookingOption->event;
                        $review = $booking->reviews()->first();
                    @endphp
                    <div class="col-6">
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
                            @if ($booking->paid_at && $review)
                                <div class="form-group">
                                    <label for="existing_rating">{{ __('Your rating') }}</label>
                                    <input disabled type="text" class="form-control" id="existing_rating" name="existing_rating"
                                        value="{{ $review->rating }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="existing_comment">{{ __('Your comment') }}</label>
                                    <textarea disabled class="form-control" id="existing_comment" name="existing_comment" rows="3" readonly>{{ $review->comment }}</textarea>
                                </div>
                                @if ($review->image_path)
                                    <div class="form-group">
                                        <label>{{ __('Photo') }}</label>
                                        <p class="text-align: center;">
                                            <img src="{{ Storage::url($review->image_path) }}" width="200" alt="Image">
                                        </p>
                                    </div>
                                @endif
                            @elseif ($booking->paid_at)
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
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
