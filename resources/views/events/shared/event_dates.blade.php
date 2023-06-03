@php
    /** @var \App\Models\Venue */
@endphp

{{-- @if(isset($service->started_at, $service->finished_at) && $service->started_at->isSameDay($service->finished_at))
    {{ __(':start until :end', [
        'start' => formatDateTime($service->started_at),
        'end' => formatTime($service->finished_at),
    ]) }}
@else
    {{ __(':start until :end', [
        'start' => isset($service->started_at) ? formatDateTime($service->started_at) : '?',
        'end' => isset($service->finished_at) ? formatDateTime($service->finished_at) : '?',
    ]) }}
@endif --}}
