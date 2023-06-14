@extends('layouts.app')

@php
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Venue[] $events */
    $states = ['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Penang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Federal Territory of Kuala Lumpur', 'Federal Territory of Labuan', 'Federal Territory of Putrajaya'];
@endphp

@section('title')
    {{ __('Homepage') }}
@endsection

<style>
    /* Add custom styles for the review section */
    .review-container {
        display: flex;
        overflow-x: auto;
        padding: 10px;
    }

    .review-item {
        flex: 0 0 auto;
        width: 200px;
        margin-right: 10px;
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }
</style>

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{-- Filter rating dropdown --}}
            <form action="{{ route('dashboard') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="q"
                        placeholder="{{ __('Search by venues, description and vendor') }}" value="{{ request()->get('q') }}">
                    <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
                    <a href="/" class="btn btn-warning" type="button">{{ __('Reset') }}</a>
                </div>

                <div class="form-group mb-3">
                    <label for="rating">{{ __('Filter by rating') }}</label>
                    <select class="form-control" id="rating" name="rating">
                        <option value="">Select rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ request()->get('rating') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label>{{ __('Filter by State') }}</label>
                    @foreach ($states as $state)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $state }}"
                                id="{{ $state }}" name="states[]"
                                {{ in_array($state, request()->get('states') ?? []) ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $state }}">
                                {{ $state }}
                            </label>
                        </div>
                    @endforeach
                </div>

            </form>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-12 col-md-12">
                    <h2>{{ __('Venue List') }}</h2>
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
                @endif
            </div>
        </div>
    </div>
    <!-- Add the review section here -->
    <div class="col-12 col-md-12">
        <h2>{{ __('Reviews') }}</h2>
        <div class="review-container">
            @foreach ($reviews as $review)
                <div class="review-item">
                    <div class="review-comment">{{ $review->user->first_name }}</div>
                    <div class="review-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <span class="rating-star">&#9733;</span>
                            @else
                                <span class="empty-star">&#9734;</span>
                            @endif
                        @endfor
                    </div>
                    <div class="review-comment">{{ $review->service->name }}</div>
                    <div class="review-comment">{{ $review->comment }}</div>
                </div>
            @endforeach
        </div>
    </div>
    
@endsection
