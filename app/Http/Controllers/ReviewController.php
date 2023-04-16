<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    public function create(Booking $booking)
    {
        $review = Review::where('booking_id', $booking->id)->first();
        return view('reviews.create', compact('booking', 'review'));
    }


    public function store(Request $request)
    {
        $bookingId = $request->input('booking_id');
        $serviceId = $request->input('service_id');
        $booking   = Booking::findOrFail($bookingId);
        $service   = Venue::findOrFail($serviceId);
        if (!$booking) {
            return redirect()->back()->with('error', __('Booking not found.'));
        }
        if (!$service) {
            return redirect()->back()->with('error', __('Venue not found.'));
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048', // added validation for image upload
        ]);

        // Check if the user is authorized to create a review for this booking
        // if (Auth::user()->cant('createReview', $booking)) {
        //     abort(403);
        // }

        $review = Review::where('booking_id', $booking->id)->first();

        if ($review) {
            return redirect()->back()->with('error', __('You have already reviewed this booking.'));
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('public/reviews', $imageName);
        } else {
            $imagePath = null;
        }

        // Create the review
        $review = new Review([
            'booking_id' => $booking->id,
            'service_id' => $service->id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'image_path' => $imagePath, // store the image path in the database
        ]);

        // Associate the review with the booking and the user
        $review->booking()->associate($booking);
        $review->service()->associate($service);
        $review->user()->associate(Auth::user());

        $review->save();

        return redirect()->route('bookings.show', $booking)->with('success', __('Your review has been saved.'));
    }

}