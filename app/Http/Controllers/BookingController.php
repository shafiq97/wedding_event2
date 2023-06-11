<?php

namespace App\Http\Controllers;

use App\Events\BookingCompleted;
use App\Exports\BookingsExportSpreadsheet;
use App\Http\Controllers\Traits\StreamsExport;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\Filters\BookingFilterRequest;
use App\Models\Booking;
use App\Models\BookingOption;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    use StreamsExport;

    public function index(
        Venue $venue,
        BookingOption $bookingOption,
        BookingFilterRequest $request
    ): StreamedResponse|View {
        // $booking = Booking::find(34); // assuming 34 is the id of the booking
        // $payment = $booking->payment;
        // dd($payment);

        $bookingOption->load([
            'form.formFieldGroups.formFields',
        ]);

        $bookingsQuery = Booking::filter($bookingOption->bookings())
            ->with([
                'bookedByUser',
                'payment'
            ]);

        // if ($request->query('output') === 'export') {
        //     $this->authorize('exportAny', Booking::class);

        //     $fileName = $venue->slug . '-' . $bookingOption->slug;
        //     return $this->streamExcelExport(
        //         new BookingsExportSpreadsheet($venue, $bookingOption, $bookingsQuery->get()),
        //         str_replace(' ', '-', $fileName) . '.xlsx',
        //     );
        // }

        $this->authorize('viewAny', Booking::class);
        $bookings = $bookingsQuery->paginate();
        // dd($bookings->first());
        return view('bookings.booking_index', [
            'venue' => $venue,
            'bookingOption' => $bookingOption,
            'bookings' => $bookings,
        ]);
    }

    public function show(Booking $booking): View
    {
        $this->authorize('view', $booking);

        return view('bookings.booking_show', [
            'booking' => $booking->loadMissing([
                'bookingOption.form.formFieldGroups.formFields',
            ]),
        ]);
    }

    public function approve_payment($bookingId): RedirectResponse
    {
        $booking = Booking::findOrFail($bookingId);

        // Check if the booking has a payment and if the payment has a receipt
        if ($booking->payment && $booking->payment->receipt) {
            // Update the 'paid_at' field to the current datetime
            $booking->paid_at = now();
            $booking->save();

            return redirect()->route('payments.show')->with('success', 'Payment marked as paid.');
        }

        return redirect()->route('payments.show')->with('error', 'No receipt available. Payment cannot be marked as paid.');
    }



    public function showPayments()
    {
        $bookings = Booking::with('payment')
            ->join('venues', 'bookings.venue_id', '=', 'venues.id')
            ->select('bookings.*', 'venues.name as venue_name')
            ->get();

        // You can customize the view name and data according to your needs
        return view('payments.user_payments', compact('bookings'));
    }


    public function store(Venue $venue, BookingOption $bookingOption, BookingRequest $request): RedirectResponse
    {

        $this->authorize('book', $bookingOption);

        $booking = new Booking();
        $booking->bookingOption()->associate($bookingOption);
        $booking->price = $bookingOption->price;
        $booking->bookedByUser()->associate(Auth::user());
        $booking->booked_at         = Carbon::now()->toDate();
        $booking->venue_id          = $venue->id;
        $booking->booked_date_until = $request->input('booked_date_until');
        $booking->booked_date_from  = $request->input('booked_date_from');

        // Calculate the number of days
        $bookedDateFrom  = Carbon::parse($booking->booked_date_from);
        $bookedDateUntil = Carbon::parse($booking->booked_date_until);
        $numberOfDays    = $bookedDateFrom->diffInDays($bookedDateUntil) + 1; // adding 1 to include the start day

        // Calculate the total cost
        $booking->price = $numberOfDays * $bookingOption->price;

        if ($booking->fillAndSave($request->validated())) {
            $message = __('Your booking has been saved successfully.')
                . ' ' . __('We will send you a confirmation by e-mail shortly.');
            Session::flash('success', $message);

            event(new BookingCompleted($booking));

            if (Auth::user()?->can('update', $booking)) {
                return redirect(route('bookings.edit', $booking));
            }

            if (Auth::user()?->can('view', $booking)) {
                return redirect(route('bookings.show', $booking));
            }
        } else {
            $message = __('Booking has been made on this the choosen date for the venue.');
            Session::flash('error', $message);
        }

        return back();
    }

    public function edit(Booking $booking): View
    {
        $this->authorize('update', $booking);
        return view('bookings.booking_form', [
            'booking' => $booking->loadMissing([
                'bookingOption.form.formFieldGroups.formFields',
            ]),
        ]);
    }

    public function update(Booking $booking, BookingRequest $request): RedirectResponse
    {
        $this->authorize('update', $booking);

        if ($booking->fillAndSave($request->validated())) {
            Session::flash('success', __('Saved successfully.'));
            return redirect(route('bookings.edit', $booking));
        }

        return back();
    }
}