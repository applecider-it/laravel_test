<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Chat
            @if ($room)
                room: {{ $room }}
            @endif
        </h2>
    </x-slot>

    <div class="pt-6 max-w-2xl mx-auto">
        @foreach ($rooms as $r)
            <a href="{{ route('chat.index', ['room' => $r]) }}" class="app-link-normal">{{ $r ? $r : 'default' }}</a>
        @endforeach
    </div>

    <div id="chat-root" data-all="{{ json_encode([
        'token' => $token,
        'wsHost' => config('myapp.ws_server_host'),
    ]) }}"></div>

    {{-- Vite の JS 読み込み --}}
    @vite(['resources/js/entrypoints/chat.ts'])
</x-app-layout>
