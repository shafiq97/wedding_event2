@extends('layouts.app')

@php
    /** @var \App\Models\Venue $service */
    /** @var \App\Models\BookingOption $bookingOption */
    /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings */
@endphp

@section('title')
    {{-- {{ $bookingOption->event }}: {{ $bookingOption }} | {{ __('Bookings') }} --}}
@endsection

@section('breadcrumbs')
    <x-nav.breadcrumb href="{{ route('events.index') }}">{{ __('Services') }}</x-nav.breadcrumb>
@endsection

@section('headline')
    {{-- <h1>{{ $bookingOption->event->name }}: {{ $bookingOption->name }}</h1> --}}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Overview</h5>
                        @php
                            $booking_counts = $bookings
                                ->groupBy('email')
                                ->map(fn($group) => $group->count())
                                ->toArray();
                        @endphp

                        <div class="row">
                            <div class="col">
                                <canvas id="booking-status-chart"></canvas>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <h3>Total sales: RM{{ $total_sales->total_sales }}</h3>
                                </div>
                                <div class="row">
                                    <h3>Total Accepted: {{ $total_accepted->total_accepted }}</h3>
                                </div>
                                <div class="row">
                                    <h3>Total Decline: {{ $total_decline->total_decline }}</h3>
                                </div>
                                <div class="row">
                                    <h3>Rating:</h3>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $avg_rating)
                                                <i style="color:#FFD700;" class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        @push('scripts')
                            <script>
                                const bookingStatusChart = document.getElementById('booking-status-chart').getContext('2d');
                                const labels = {!! json_encode(array_keys($booking_counts)) !!};
                                const data = {!! json_encode(array_values($booking_counts)) !!};
                                new Chart(bookingStatusChart, {
                                    type: 'pie',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            data: data,
                                            backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56']
                                        }]
                                    },
                                    options: {
                                        legend: {
                                            position: 'right'
                                        }
                                    }
                                });
                            </script>
                        @endpush
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Messages</h5>
                        <div class="container">
                            <h1>My Chats</h1>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Chat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($chats as $chat)
                                        <tr>
                                            <td> <a
                                                    href="{{ route('landscaper_profile.index', ['user_id' => $chat->landscaper_id, 'user_name' => $chat->first_name]) }}">{{ $chat->first_name }}</a></span>
                                            </td>
                                            <td>{{ $chat->created_at->format('d/m/Y H:i') }}</td>
                                            <td><a href="{{ route('chat.landscaper', ['user_id' => $chat->user_id, 'landscaper_id' => $chat->landscaper_id, 'user_name' => $chat->first_name]) }}"
                                                    class="btn btn-warning">Chat</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer Rating</h5>
                        {{-- <p class="card-text">This is the third card.</p> --}}
                        @foreach ($services as $service)
                            <br>
                            <h4>{{ $service->name }}</h4>
                            <div>Venue rating:
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $service->service_rating)
                                        <i style="color:#FFD700;" class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div>Reviews:
                                @foreach ($service->reviews as $review)
                                    <div>
                                        <strong>{{ $review->user->first_name }}</strong>: {{ $review->comment }}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Card 4</h5>
                        <p class="card-text">This is the fourth card.</p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
