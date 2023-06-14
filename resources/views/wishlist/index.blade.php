@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center">My Wedding Venue Wishlist</h1>

        @if (count($wishlist) === 0)
            <div class="alert alert-info text-center">
                Your wishlist is empty. Start exploring wedding venues and add them to your wishlist.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach ($wishlist as $item)
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                            </div>
                            <div class="card-footer">
                                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove from Wishlist</button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
