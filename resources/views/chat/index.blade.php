@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Chats</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Date</th>
                    <th>Chat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chats as $chat)
                    <tr>
                        <td> <a
                                href="{{ route('landscaper_profile.index', ['user_id' => $chat->landscaper_id, 'user_name' => $chat->first_name]) }}">{{ $chat->first_name }}</a></span>
                        </td>
                        <td>{{ $chat->created_at->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('chat.landscaper', ['user_id' => $chat->user_id, 'landscaper_id' => $chat->landscaper_id, 'user_name' => $chat->first_name]) }}"
                                class="btn btn-warning">Chat</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
