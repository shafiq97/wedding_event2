@extends('layouts.app')
<style>
    .container {
        /* margin: 40px auto;
        max-width: 800px; */
        text-align: center;
    }

    h1 {
        margin-bottom: 20px;
    }

    .payment-details {
        margin-bottom: 20px;
    }

    .receipt-container {
        border: 1px solid #ddd;
        padding: 20px;
    }

    h3 {
        margin-bottom: 10px;
    }

    .receipt img {
        max-width: 100%;
        max-height: 400px;
    }

    .pdf-receipt {
        display: inline-block;
        background-color: #f1f1f1;
        padding: 10px 20px;
        border-radius: 4px;
    }

    .unsupported-format {
        color: red;
        font-weight: bold;
    }
</style>
@section('content')
    <div class="container">
        <h1>Payment</h1>
        <div class="payment-details">
            <p>Payment ID: {{ $payment->payment_id }}</p>
            <!-- Display other payment details -->
        </div>
        <div class="receipt-container">
            <h3>Payment Receipt:</h3>
            <div class="receipt">
                @if (Str::endsWith($payment->receipt, ['.jpg', '.jpeg', '.png', '.gif']))
                    <img src="{{ Storage::url($payment->receipt) }}" alt="Payment Receipt">
                @elseif (Str::endsWith($payment->receipt, ['.pdf']))
                    <div class="pdf-receipt">
                        <a href="{{ Storage::url($payment->receipt) }}" target="_blank">View Receipt (PDF)</a>
                    </div>
                @else
                    <p class="unsupported-format">Unsupported file format</p>
                @endif
            </div>
        </div>
    </div>
@endsection