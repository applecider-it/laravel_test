<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Chat
            @if ($room != 'default')
                room: {{ $room }}
            @endif
        </h2>
    </x-slot>

    <div class="app-container">
        <div class="space-x-4">
            @foreach ($rooms as $r)
                <a href="{{ route('chat.index', ['room' => $r]) }}" class="app-link-normal">{{ $r }}</a>
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
