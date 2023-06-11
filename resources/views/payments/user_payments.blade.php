@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display error message -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h1>Bookings</h1>
        <table id="bookings-table" class="table table-striped">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Venue</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Receipt</th>
                    <th>Paid At</th>
                    <!-- Add more table headers for other columns -->
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->venue_name }}</td>
                        <td>{{ $booking->first_name }}</td>
                        <td>{{ $booking->last_name }}</td>
                        <td>{{ $booking->email }}</td>
                        <td>
                            @if ($booking->payment && $booking->payment->receipt)
                                <a href="{{ Storage::url($booking->payment->receipt) }}" target="_blank">Download Receipt</a>
                            @else
                                No receipt available
                            @endif
                        </td>
                        @if ($booking->paid_at)
                            <td>{{ $booking->paid_at }}</td>
                        @else
                            <td><a class="btn btn-primary"
                                    href="{{ route('approve.payment', ['booking_id' => $booking->id]) }}">Mark as paid</a>
                            </td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#bookings-table').DataTable();
        });
    </script>
@endsection
