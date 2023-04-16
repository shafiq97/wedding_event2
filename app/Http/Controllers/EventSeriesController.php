<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventSeriesRequest;
use App\Http\Requests\Filters\EventSeriesFilterRequest;
use App\Models\ServiceSeries;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class EventSeriesController extends Controller
{
    public function index(EventSeriesFilterRequest $request): View
    {
        $this->authorize('viewAny', ServiceSeries::class);

        return view('event_series.event_series_index', [
            'eventSeries' => ServiceSeries::filter()
                ->with([
                    'parentEventSeries',
                ])
                ->withCount([
                    'events',
                ])
                ->paginate(),
        ]);
    }

    public function show(ServiceSeries $eventSeries): View
    {
        $this->authorize('view', $eventSeries);

        return view('event_series.event_series_show', [
            'eventSeries' => $eventSeries->loadMissing([
                'events.location',
            ]),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', ServiceSeries::class);

        return view('event_series.event_series_form', $this->formValues());
    }

    public function store(EventSeriesRequest $request): RedirectResponse
    {
        $this->authorize('create', ServiceSeries::class);

        $eventSeries = new ServiceSeries();
        if ($eventSeries->fillAndSave($request->validated())) {
            Session::flash('success', __('Created successfully.'));
            return redirect(route('event-series.edit', $eventSeries));
        }

        return back();
    }

    public function edit(ServiceSeries $eventSeries): View
    {
        $this->authorize('update', $eventSeries);

        return view('event_series.event_series_form', $this->formValues([
            'eventSeries' => $eventSeries,
        ]));
    }

    public function update(ServiceSeries $eventSeries, EventSeriesRequest $request): RedirectResponse
    {
        $this->authorize('update', $eventSeries);

        if ($eventSeries->fillAndSave($request->validated())) {
            Session::flash('success', __('Saved successfully.'));
            // Slug may have changed, so we need to generate the URL here!
            return redirect(route('event-series.edit', $eventSeries));
        }

        return back();
    }

    private function formValues(array $values = []): array
    {
        return array_replace([
            'allEventSeries' => ServiceSeries::query()
                ->whereNull('parent_event_series_id')
                ->orderBy('name')
                ->get(),
        ], $values);
    }
}
