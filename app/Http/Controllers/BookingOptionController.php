<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingOptionRequest;
use App\Models\BookingOption;
use App\Models\Venue;
use App\Models\Form;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

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
