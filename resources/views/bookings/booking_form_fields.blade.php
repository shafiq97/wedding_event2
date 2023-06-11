@php
    /** @var ?\App\Models\Booking $booking */
    /** @var \App\Models\BookingOption $bookingOption */
@endphp
@php
    use Illuminate\Support\Facades\Storage;
@endphp

@isset($bookingOption->form)
    @foreach ($bookingOption->form->formFieldGroups as $group)
        @if ($group->show_name)
            <h2 id="{{ Str::slug($group->name) }}">
                {{ $group->name }}</h2>
        @endif
        @isset($group->description)
            <p class="lead">{!! $group->description !!}</p>
        @endisset

        <div class="row">
            @foreach ($group->formFields as $field)
                @php
                    $allowedValues = array_combine($field->allowed_values ?? [], $field->allowed_values ?? []);
                    $inputName = $field->input_name . ($field->isMultiCheckbox() ? '[]' : '');
                @endphp
                @if ($field->type === 'hidden')
                    <x-form.input name="{{ $field->input_name }}" type="{{ $field->type }}" :value="$field->allowed_values[0] ?? null" />
                @else
                    <div class="{{ $field->container_class ?? 'col-12' }}">
                        <x-form.row>
                            @if ($field->type === 'checkbox' && ($field->allowed_values === null || count($field->allowed_values) === 1))
                                <x-form.input name="{{ $field->input_name }}" type="{{ $field->type }}" :value="$booking?->getFieldValue($field)">
                                    {{ $field->allowed_values[0] ?? $field->name }}
                                    @if ($field->required)
                                        *
                                    @endif
                                </x-form.input>
                            @else
                                <x-form.label for="{{ $inputName }}">{{ $field->name }} @if ($field->required)
                                        *
                                    @endif
                                </x-form.label>
                                @if (!$field->required || $field->type === 'checkbox')
                                    <x-form.input name="{{ $inputName }}" type="{{ $field->type }}" :options="$allowedValues"
                                        :value="$booking?->getFieldValue($field)" />
                                @else
                                    <x-form.input name="{{ $inputName }}" type="{{ $field->type }}" :options="$allowedValues"
                                        :value="$booking?->getFieldValue($field)" required />
                                @endif
                            @endif
                            @if (isset($field->hint) && $field->type !== 'hidden')
                                <div id="{{ $field->id }}-hint" class="form-text">
                                    {!! $field->hint !!}
                                </div>
                            @endif
                        </x-form.row>
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
@else
    {{-- no form set, so use the default form --}}
    <div class="row">
        @if ($booking)
            @if ($booking->payment)
                <div class="col-12 col-md-4">
                    <x-form.row>
                        <a href="{{ Storage::url($booking->payment->receipt) }}" download>
                            <button type="button" class="btn btn-primary">Download Receipt</button>
                        </a>
                    </x-form.row>
                </div>
            @else
                <p>No payment found for this booking</p>
            @endif
        @endif
    </div>

    <hr>
    <div class="row">
        <div class="col-12 col-md-6">
            <x-form.row>
                <x-form.label for="first_name">{{ __('First name') }}</x-form.label>
                <x-form.input name="first_name" type="text" :value="$booking->first_name ?? null" />
            </x-form.row>
        </div>
        <div class="col-12 col-md-6">
            <x-form.row>
                <x-form.label for="last_name">{{ __('Last name') }}</x-form.label>
                <x-form.input name="last_name" type="text" :value="$booking->last_name ?? null" />
            </x-form.row>
        </div>
    </div>
    <x-form.row>
        <x-form.label for="phone">{{ __('Phone number') }}</x-form.label>
        <x-form.input name="phone" type="tel" :value="$booking->phone ?? null" />
    </x-form.row>
    <x-form.row>
        <x-form.label for="email">{{ __('E-mail') }}</x-form.label>
        <x-form.input name="email" type="email" :value="$booking->email ?? null" />
    </x-form.row>
    <x-form.row>
        <x-form.label for="bookingDateFrom">{{ __('Booking Date From') }}</x-form.label>
        @if ($booking)
            <x-form.input name="booked_date_from" type="date" min="{{ date('Y-m-d') }}" :value="$booking->booked_date_from"
                :disabled="isset($booking->booked_date_from)" />
        @else
            <x-form.input name="booked_date_from" type="date" min="{{ date('Y-m-d') }}" />
        @endif
    </x-form.row>
    <x-form.row>
        <x-form.label for="bookingDateUntil">{{ __('Booking Date Until') }}</x-form.label>
        @if ($booking)
            <x-form.input name="booked_date_until" type="date" min="{{ date('Y-m-d') }}" :value="$booking->booked_date_until"
                :disabled="isset($booking->booked_date_until)" />
        @else
            <x-form.input name="booked_date_until" type="date" min="{{ date('Y-m-d') }}" />
        @endif
    </x-form.row>

    <x-form.row>
        <x-form.label>{{ __('Number of days') }}</x-form.label>
        <x-form.input type="text" name="num_of_days" :disabled="true" />
    </x-form.row>
    @include('_shared.address_fields_form', [
        'address' => $booking,
    ])
    <x-form.row>
        <div class="form-check">
            <input name="terms" type="checkbox" class="form-check-input" id="terms" required>
            <label class="form-check-label" for="terms">
                I agree to the <a href="https://harlequin-reine-58.tiiny.site/" target="_blank">Terms and Conditions</a>*
            </label>
        </div>
    </x-form.row>


@endisset
<script>
    var startDateInput = document.querySelector('input[name="booked_date_from"]');
    var endDateInput = document.querySelector('input[name="booked_date_until"]');
    var numOfDaysInput = document.querySelector('input[name="num_of_days"]');

    function updateNumberOfDays() {
        var startDate = new Date(startDateInput.value);
        var endDate = new Date(endDateInput.value);

        if (startDate && endDate && !isNaN(startDate) && !isNaN(endDate)) {
            var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
            var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
            numOfDaysInput.value = diffDays + 1;
        } else {
            numOfDaysInput.value = ''; // clear the input if dates are not valid
        }
    }

    startDateInput.addEventListener('change', updateNumberOfDays);
    endDateInput.addEventListener('change', updateNumberOfDays);

    window.onload = updateNumberOfDays; // calculate on page load
</script>

<script>
    const bookedDateFrom = document.getElementById('booked_date_from');
    const bookedDateUntil = document.getElementById('booked_date_until');

    bookedDateFrom.addEventListener('change', validateDates);
    bookedDateUntil.addEventListener('change', validateDates);

    function validateDates() {
        const fromDate = new Date(bookedDateFrom.value);
        const untilDate = new Date(bookedDateUntil.value);

        if (fromDate > untilDate) {
            alert("The 'Booking Date Until' must be the same as or after 'Booking Date From'.");
            bookedDateUntil.value = bookedDateFrom.value;
        }
    }
</script>
