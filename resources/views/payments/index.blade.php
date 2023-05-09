@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Payment</h1>

        <form action="{{ route('payment.process', $booking->id) }}" method="post">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            <label for="">Total RM</label><br>
            <input type="text" readonly name="amount" value="{{ $booking->price }}">
            <br><br>
            <label for="">Payment method</label> <br>
            <input type="text" name="payment_method" value="Credit Card">
            <br><br>
            <button type="submit" class="btn btn-primary">{{ __('Pay Now') }}</button>
        </form>
    </div>
@endsection
