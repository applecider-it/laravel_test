<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Chat Echo
            @if ($room != 'default')
                room: {{ $room }}
            @endif
        </h2>
    </x-slot>

    <div class="pt-6 max-w-2xl mx-auto space-x-4">
        @foreach ($rooms as $r)
            <a href="{{ route('chat.index_echo', ['room' => $r]) }}" class="app-link-normal">{{ $r }}</a>
        @endforeach
    </div>

    <div id="chat-root" data-all="{{ json_encode([
        'room' => $room,
    ]) }}">
        @include('partials.message.loading')
    </div>

    {{-- Vite の JS 読み込み --}}
    @vite(['resources/js/entrypoints/chat_echo.ts'])
</x-app-layout>
