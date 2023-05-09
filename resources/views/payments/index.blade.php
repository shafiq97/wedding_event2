@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Payment</h1>

        <form action="{{ route('payment.process', $booking->id) }}" method="post">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            <input type="hidden" name="amount" value="{{ $booking->price }}">
            <input type="hidden" name="payment_method" value="Credit Card">
            <button type="submit" class="btn btn-primary">{{ __('Pay Now') }}</button>
        </form>
    </div>
@endsection
