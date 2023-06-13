@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Add this at the top of your form, before the form fields -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h1>Make With Payment</h1>

        <div>
            <img src="{{ asset('storage/qrpayment.jpeg') }}">
        </div>
        <div class="mt-2 mb-2">
            <h3>Account No: 12195020252755</h3>
        </div>

        <!-- Add enctype attribute to your form tag -->
        <form action="{{ route('payment.process', $booking->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
            <label for="">Total RM</label><br>
            <input type="text" readonly name="amount" value="{{ $booking->price }}">
            <br><br>
            {{-- <label for="">Payment method</label> <br> --}}
            <input type="hidden" name="payment_method" value="Qr">


            @if ($payments)
                @if (!$booking->paid_at)
                    <h1>Your payment is processing, wait for admin approval</h1>
                @endif
            @else
                <!-- Add this to your form fields -->
                <label for="receipt">Upload Receipt (PDF or Image)</label><br>
                <input type="file" name="receipt" accept=".pdf, .jpg, .jpeg, .png">
                <br><br>
                <button type="submit" class="btn btn-primary">{{ __('Pay Now') }}</button>
            @endif





        </form>
    </div>
@endsection
