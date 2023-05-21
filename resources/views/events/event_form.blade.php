@extends('layouts.app')

@php
    /** @var ?\App\Models\Venue $service */
@endphp

@section('title')
    @isset($service)
        {{ __('Edit :name', ['name' => $service->name]) }}
    @else
        {{ __('Create Wedding Venue') }}
    @endisset
@endsection

@section('breadcrumbs')
    <x-nav.breadcrumb href="{{ route('events.index') }}">{{ __('Venues') }}</x-nav.breadcrumb>
    <x-nav.breadcrumb />
@endsection

@section('content')
    <x-form method="{{ isset($service) ? 'PUT' : 'POST' }}" enctype="multipart/form-data"
        action="{{ isset($service) ? route('events.update', $service) : route('events.store') }}">
        <div class="row">
            <div class="col-12 col-md-6">
                <x-form.row>
                    <x-form.label for="name">{{ __('Name') }}</x-form.label>
                    <x-form.input name="name" type="text" :value="$service->name ?? null" />
                </x-form.row>
                {{-- <x-form.row>
                    <x-form.label for="slug">{{ __('Slug') }}</x-form.label>
                    <x-form.input name="slug" type="text" aria-describedby="slugHint"
                                  :value="$service->slug ?? null"/>
                    <div id="slugHint" class="form-text">
                        {!! __('This field defines the path in the URL, such as :url. If you leave it empty, is auto-generated for you.', [
                            'url' => isset($service->slug)
                                ? sprintf('<a href="%s" target="_blank">%s</a>', route('events.show', $service), route('events.show', $service, false))
                                : '<strong>' . route('events.show', Str::of(__('Name of the event'))->snake('-')) . '</strong>'
                        ]) !!}
                    </div>
                </x-form.row> --}}
                <x-form.row>
                    <x-form.label for="description">{{ __('Description') }}</x-form.label>
                    <x-form.input name="description" type="text" :value="$service->description ?? null" />
                </x-form.row>
                <x-form.row>
                    <x-form.label for="website_url">{{ __('Website') }}</x-form.label>
                    <x-form.input name="website_url" type="text" :value="$service->website_url ?? null" />
                </x-form.row>
                <x-form.row>
                    <x-form.label for="visibility">{{ __('Visibility') }}</x-form.label>
                    <x-form.select name="visibility" :options="\App\Options\Visibility::keysWithNames()" :value="$service->visibility->value ?? null" />
                </x-form.row>
                {{-- <x-form.row>
                    <x-form.label for="started_at">{{ __('Start date') }}</x-form.label>
                    <x-form.input name="started_at" type="datetime-local"
                                  :value="isset($service->started_at) ? $service->started_at->format('Y-m-d\TH:i') : null"/>
                </x-form.row>
                <x-form.row>
                    <x-form.label for="finished_at">{{ __('End date') }}</x-form.label>
                    <x-form.input name="finished_at" type="datetime-local"
                                  :value="isset($service->finished_at) ? $service->finished_at->format('Y-m-d\TH:i') : null"/>
                </x-form.row> --}}
            </div>
            <div class="col-12 col-md-6">
                <x-form.row>
                    <x-form.label for="location_id">{{ __('Location') }}</x-form.label>
                    <x-form.select name="location_id" :options="$locations->pluck('nameOrAddress', 'id')" :value="$service->location_id ?? null" />
                </x-form.row>
                <x-form.row>
                    <x-form.label for="images">{{ __('Images') }}</x-form.label>
                    <x-form.input name="images[]" type="file" accept="image/*" id="image-input" multiple />
                </x-form.row>
                <x-form.row>
                    <x-form.label>{{ __('ImagePreview') }}</x-form.label>
                    {{-- <img src="{{ asset('storage/'.$service->image) }}" width="200" alt="Image"> --}}
                    @if (isset($service))
                        <img src="{{ isset($service) && $service->image ? asset('storage/' . $service->image) : '' }}"
                            id="image-preview" style="max-width: 100%; height: auto;">
                    @else
                        <div id="image-preview"></div>
                    @endif
                </x-form.row>
                @push('scripts')
                    <script>
                        const input = document.querySelector('#image-input');
                        const preview = document.querySelector('#image-preview');

                        input.addEventListener('change', () => {
                            preview.innerHTML = ""; // clear preview
                            const files = input.files;
                            for (let i = 0; i < files.length; i++) {
                                const file = files[i];
                                if (file) {
                                    const reader = new FileReader();
                                    const img = document.createElement('img');
                                    img.style.maxWidth = "100%";
                                    img.style.height = "auto";
                                    reader.addEventListener('load', () => {
                                        img.src = reader.result;
                                        preview.appendChild(img);
                                    });
                                    reader.readAsDataURL(file);
                                }
                            }
                        });
                    </script>
                @endpush


            </div>
        </div>

        <x-button.group>
            <x-button.save>
                @isset($service)
                    {{ __('Save') }}
                @else
                    {{ __('Create') }}
                @endisset
            </x-button.save>

            <x-button.cancel href="{{ route('events.index') }}" />
        </x-button.group>
    </x-form>

    @if (isset($service))
        <form method="POST" action="{{ route('events.destroy', $service) }}">
            @csrf
            @method('DELETE')
            <button class="btn btn-warning" type="submit">{{ __('Delete') }}</button>
        </form>
    @endif


    <x-text.timestamp :model="$service ?? null" />
@endsection
