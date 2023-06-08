<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingOptionRequest;
use App\Models\BookingOption;
use App\Models\Venue;
use App\Models\Form;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use App\Models\Booking;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class BookingOptionController extends Controller
{
    public function show(Venue $service, BookingOption $bookingOption): View
    {
        $this->authorize('view', $bookingOption);

        return view('booking_options.booking_option_show', [
            'service' => $service,
            'bookingOption' => $bookingOption,
        ]);
    }

    public function create(Venue $service): View
    {
        $this->authorize('create', BookingOption::class);

        return view('booking_options.booking_option_form', $this->formValues([
            'service' => $service,
        ]));
    }

    public function destroy(Venue $service, BookingOption $bookingOption): RedirectResponse
    {
        $this->authorize('delete', $bookingOption);

        try {
            // Begin a database transaction
            DB::beginTransaction();

            // Check if there are any bookings associated with the booking option
            if (Booking::where('booking_option_id', $bookingOption->id)->exists()) {
                throw new \Exception('Cannot delete the booking option because there are associated bookings.');
            }

            // Delete the booking option
            $bookingOption->delete();

            // Commit the transaction
            DB::commit();

            Session::flash('success', __('Deleted successfully.'));
            return redirect(route('dashboard'));
        } catch (\Exception $e) {
            // Roll back the transaction in case of any exception
            DB::rollBack();

            // Handle the specific exception caused by the integrity constraint violation
            if ($e instanceof \Illuminate\Database\QueryException && $e->getCode() === '23000') {
                Session::flash('error', __('Cannot delete the booking option because there are associated bookings.'));
            } else {
                Session::flash('error', __('An error occurred while deleting the booking option.'));
            }

            return redirect(route('dashboard'));
        }
    }


    public function store(Venue $service, BookingOptionRequest $request): RedirectResponse
    {
        $this->authorize('create', BookingOption::class);

        $bookingOption = new BookingOption();
        $bookingOption->event()->associate($service);
        if ($bookingOption->fillAndSave($request->validated())) {
            Session::flash('success', __('Created successfully.'));
            return redirect(route('booking-options.edit', [$service, $bookingOption]));
        }

        return back();
    }

    public function edit(Venue $service, BookingOption $bookingOption): View
    {
        $this->authorize('update', $bookingOption);

        return view('booking_options.booking_option_form', $this->formValues([
            'bookingOption' => $bookingOption,
            'service' => $service,
        ]));
    }

    public function update(Venue $service, BookingOption $bookingOption, BookingOptionRequest $request): RedirectResponse
    {
        $this->authorize('update', $bookingOption);

        if ($bookingOption->fillAndSave($request->validated())) {
            Session::flash('success', __('Saved successfully.'));
            // Slug may have changed, so we need to generate the URL here!
            return redirect(route('booking-options.edit', [$service, $bookingOption]));
        }

        return back();
    }

    private function formValues(array $values = []): array
    {
        return array_replace([
            'forms' => Form::query()
                ->orderBy('name')
                ->get(),
        ], $values);
    }
}