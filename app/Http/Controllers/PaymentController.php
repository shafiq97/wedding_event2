<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'booking_id' => [
                'required',
                'integer',
                'exists:bookings,id',
                Rule::unique('payments', 'booking_id')
                    ->where('payment_method', $request->input('payment_method')),
            ],
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'receipt' => 'required|mimes:pdf,jpg,jpeg,png|max:2048', // Validate the receipt file
            // Add other fields as needed
        ]);
    
        // Store the receipt file
        $receiptPath = $request->file('receipt')->store('receipts', 'public');
        // Create a new payment instance
        $payment = new Payment([
            'booking_id' => $request->input('booking_id'),
            'amount' => $request->input('amount'),
            'payment_method' => $request->input('payment_method'),
            'receipt' => $receiptPath, // Store the path to the receipt file
            // Add other fields as needed
        ]);
    
        // Save the payment to the database
        $payment->save();
    
        // Redirect or return a response as needed
        return redirect()->route('dashboard')->with('success', 'Payment processed successfully.');
    }
    
}