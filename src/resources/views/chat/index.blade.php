<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Chat
        </h2>
    </x-slot>

    <div id="chat-root" data-all="{{ json_encode([
        'token' => $token,
        'wsHost' => config('myapp.ws_server_host'),
    ]) }}"></div>

    {{-- Vite の JS 読み込み --}}
    @vite(['resources/js/entrypoints/chat.ts'])
</x-app-layout>
