@php
    /** @var \App\Models\Venue $service */
@endphp

<x-list.group>
    @isset($service->description)
        <li class="list-group-item">
            {{ $service->description }}
        </li>
    @endisset
    @isset($service->website_url)
        <li class="list-group-item">
            <a href="{{ $service->website_url }}" target="_blank">{{ __('Website') }}</a>
        </li>
    @endisset
    <li class="list-group-item d-flex">
        <span class="me-3">
            <i class="fa fa-fw fa-eye" title="{{ __('Visibility') }}"></i>
        </span>
        <div>
            <x-badge.visibility :visibility="$service->visibility" />
        </div>
    </li>
    {{-- <li class="list-group-item d-flex">
        <span class="me-3">
            <i class="fa fa-fw fa-clock" title="{{ __('Date') }}"></i>
        </span>
        <div>@include('events.shared.event_dates')</div>
    </li> --}}
    {{-- <li class="list-group-item d-flex">
        <span class="me-3">
            <i class="fa fa-fw fa-location-pin" title="{{ __('Address') }}"></i>
        </span>
        <div>
            @foreach ($service->location->fullAddressBlock as $line)
                {{ $line }}@if (!$loop->last)
                    <br>
                @endif
            @endforeach
        </div>
    </li> --}}
    <li class="list-group-item d-flex">
        <span class="me-3">
            <i class="fa fa-fw fa-clock" title="{{ __('Date') }}"></i>
        </span>
        <div>
            @isset($bookingOption->available_from)
                <div class="small">
                    {{ __('Booking period') }}:
                    {{ formatDateTime($bookingOption->available_from) }}
                    -
                    @isset($bookingOption->available_until)
                        {{ formatDateTime($bookingOption->available_until) }}
                    @else
                        {{ __('forever') }}
                    @endisset
                </div>
            @endisset
        </div>
    </li>

    {{-- <li class="list-group-item d-flex">
        <span class="me-3">
            <i class="fa fa-fw fa-sitemap" title="{{ __('Organizations') }}"></i>
        </span>
        <div>
            @if ($service->organizations->count() === 0)
                {{ __('none') }}
            @else
                <ul class="list-unstyled">
                    @foreach ($service->organizations as $organization)
                        <li>{{ $organization->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </li> --}}
</x-list.group>
