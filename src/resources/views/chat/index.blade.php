<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Chat
            ( room: {{ $rooms[$room] }} )
        </h2>
    </x-slot>

    <div class="app-container">
        <div class="space-x-4">
            @foreach ($rooms as $key => $val)
                @if ($key === $room)
                    <span>{{ $val }}</span>
                @else
                    <a href="{{ route('chat.index', ['room' => $key]) }}" class="app-link-normal">{{ $val }}</a>
                @endif
            @endforeach
        </div>

        <div class="my-4">
            <div id="chat-root" data-all="{{ json_encode([
                'room' => $room,
                'token' => $token,
                'wsHost' => config('myapp.ws_server_host'),
            ]) }}">
                @include('partials.message.loading')
            </div>
        </div>
    </div>



    {{-- Vite の JS 読み込み --}}
    @vite(['resources/js/entrypoints/chat.ts'])
</x-app-layout>
