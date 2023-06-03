@php
    $address = $address ?? ($location ?? ($user ?? null));
    
@endphp
@php
    $states = ['Johor', 'Kedah', 'Kelantan', 'Malacca', 'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Federal Territory of Kuala Lumpur', 'Federal Territory of Labuan', 'Federal Territory of Putrajaya'];
@endphp

<x-form.row>
    <x-form.label for="state">{{ __('State') }}</x-form.label>
    <select name="state" id="state" class="form-control">
        @foreach ($states as $state)
            <option value="{{ $state }}" {{ $address->state == $state ? 'selected' : '' }}>
                {{ $state }}
            </option>
        @endforeach
    </select>
</x-form.row>

<div class="row">
    <div class="col-12 col-md-8">
        <x-form.row>
            <x-form.label for="street">{{ __('Street') }}</x-form.label>
            <x-form.input name="street" type="text" :value="$address->street ?? null" />
        </x-form.row>
    </div>
    <div class="col-12 col-md-4">
        <x-form.row>
            <x-form.label for="house_number">{{ __('House Number') }}</x-form.label>
            <x-form.input name="house_number" type="text" :value="$address->house_number ?? null" />
        </x-form.row>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-4">
        <x-form.row>
            <x-form.label for="postal_code">{{ __('Postal code') }}</x-form.label>
            <x-form.input name="postal_code" type="text" :value="$address->postal_code ?? null" />
        </x-form.row>
    </div>
    <div class="col-12 col-md-8">
        <x-form.row>
            <x-form.label for="city">{{ __('City') }}</x-form.label>
            <x-form.input name="city" type="text" :value="$address->city ?? null" />
        </x-form.row>
    </div>
</div>
<x-form.row>
    <x-form.label for="state">{{ __('State') }}</x-form.label>
    <select name="state" id="state" class="form-control">
        @foreach ($states as $state)
            <option value="{{ $state }}" {{ $address->state == $state ? 'selected' : '' }}>
                {{ $state }}
            </option>
        @endforeach
    </select>
</x-form.row>
