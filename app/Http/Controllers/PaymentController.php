<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // ...
    public function index(Request $request, $booking)
    {
        // Load the booking information
        $booking = Booking::findOrFail($booking);
    
        return view('payments.index', compact('booking'));
    }
    

    public function process(Request $request)
    {
        // Validate the request data
        $request->validate([
            'booking_id' => 'required|integer|exists:bookings,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            // Add other fields as needed
        ]);

        // Create a new payment instance
        $payment = new Payment([
            'booking_id' => $request->input('booking_id'),
            'amount' => $request->input('amount'),
            'payment_method' => $request->input('payment_method'),
            // Add other fields as needed
        ]);

        // Save the payment to the database
        $payment->save();

        // Redirect or return a response as needed
        return redirect()->route('some_route')->with('success', 'Payment processed successfully.');
    }
}
