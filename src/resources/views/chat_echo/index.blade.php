<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Chat Echo
            @if ($room != 'default')
                room: {{ $room }}
            @endif
        </h2>
    </x-slot>

    <div class="app-container">
        <div class="space-x-4">
            @foreach ($rooms as $r)
                <a href="{{ route('chat_echo.index', ['room' => $r]) }}" class="app-link-normal">{{ $r }}</a>
            @endforeach
        </div>

        <div class="my-4">
            <div id="chat-root" data-all="{{ json_encode([
                'room' => $room,
            ]) }}">
                @include('partials.message.loading')
            </div>
        </div>
    </div>

    {{-- Vite の JS 読み込み --}}
    @vite(['resources/js/entrypoints/chat-echo.ts'])
</x-app-layout>
