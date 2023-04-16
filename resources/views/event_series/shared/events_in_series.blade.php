@php
    /** @var \App\Models\ServiceSeries $eventSeries */
@endphp

@include('events.shared.event_list', [
    'events' => $eventSeries->events,
    'noEventsMessage' => __('This event series does not contain any events yet.'),
])
