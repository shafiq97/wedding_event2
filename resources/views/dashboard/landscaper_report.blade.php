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
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Overview</h5>
                        <!-- Dropdown filter -->
                        <div class="mb-3">
                            <label for="booking-filter" class="form-label">Filter by Vendor:</label>
                            <select id="booking-filter" class="form-select">
                                <option value="all">All</option>
                                @foreach ($vendors as $vendorId => $vendorName)
                                    <option value="{{ $vendorId }}">{{ $vendorName }}</option>
                                @endforeach
                            </select>
                        </div>

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
                                    <h3 id="total-approve">Total Approve: {{ $total_accepted->total_accepted }}</h3>
                                </div>
                                <div class="row">
                                    <h3 id="total-pending">Total Pending: {{ $total_decline->total_decline }}</h3>
                                </div>
                                <div class="row">
                                    <h3>Average Rating:</h3>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <canvas id="sales-line-chart"></canvas>
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
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const bookingStatusChart = document.getElementById('booking-status-chart').getContext('2d');
        const labels = ['Total Approve', 'Total Pending'];
        const data = [
            {{ $total_accepted->total_accepted }},
            {{ $total_decline->total_decline }}
        ];
        let chart = null;

        function updateChart(selectedVendor) {
            if (selectedVendor !== 'all') {
                // Get the total approve and total pending values for the selected vendor
                let totalApprove = 0;
                let totalPending = 0;
                const vendorStats = {!! json_encode($vendorStats) !!};
                if (vendorStats.hasOwnProperty(selectedVendor)) {
                    totalApprove = vendorStats[selectedVendor].total_approved;
                    totalPending = vendorStats[selectedVendor].total_pending;
                }

                // Update the total approve and total pending elements
                document.getElementById('total-approve').textContent = 'Total Approve: ' + totalApprove;
                document.getElementById('total-pending').textContent = 'Total Pending: ' + totalPending;

                // Filter the labels and data based on the selected vendor
                chart.data.labels = ['Total Approve', 'Total Pending'];
                chart.data.datasets[0].data = [totalApprove, totalPending];
                chart.update();
            } else {
                // Reset the total approve and total pending elements when "All" is selected
                document.getElementById('total-approve').textContent =
                    '{{ $total_accepted->total_accepted }}';
                document.getElementById('total-pending').textContent =
                    '{{ $total_decline->total_decline }}';

                // Update the chart with the initial data
                chart.data.labels = labels;
                chart.data.datasets[0].data = data;
                chart.update();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            chart = new Chart(bookingStatusChart, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#36A2EB', '#FFCE56']
                    }]
                },
                options: {
                    legend: {
                        position: 'right'
                    }
                }
            });

            const bookingFilterSelect = document.getElementById('booking-filter');
            bookingFilterSelect.addEventListener('change', function() {
                updateChart(this.value);
            });
        });
    </script>
@endpush
@push('scripts')
    <script>
        const salesLineChart = document.getElementById('sales-line-chart').getContext('2d');
        const salesData = {!! json_encode($salesData) !!};
        new Chart(salesLineChart, {
            type: 'line',
            data: {
                labels: Object.keys(salesData),
                datasets: [{
                    data: Object.values(salesData),
                    borderColor: 'rgba(75, 192, 192, 0.6)',
                    fill: false
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Monthly Sales'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        },
                        ticks: {
                            maxTicksLimit: 12, // Set the maximum number of ticks to 12
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Sales'
                        }
                    }]
                }
            }
        });
    </script>
@endpush
