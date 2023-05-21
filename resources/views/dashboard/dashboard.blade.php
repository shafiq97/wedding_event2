@extends('layouts.app')

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
        <div class="col-md-4">
            {{-- Filter rating dropdown --}}
            <form action="{{ route('dashboard') }}" method="GET">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="q"
                        placeholder="{{ __('Search by venues, description and vendor') }}">
                    <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
                    <a href="/" class="btn btn-warning" type="button">{{ __('Reset') }}</a>
                </div>
        
                <div class="form-group mb-3">
                    <label for="rating">{{ __('Filter by rating') }}</label>
                    <select class="form-control" id="rating" name="rating">
                        <option value="">Select rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
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
        <div class="col-md-8">
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
                    {{-- Remaining code here --}}
                @endif
            </div>
        </div>
    </div>
@endsection
