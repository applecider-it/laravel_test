<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat
        </h2>
    </x-slot>

    <div id="chat-root" data-all="{{ json_encode([
        'token' => $token,
        'wsHost' => env('WS_SERVER_HOST'),
    ]) }}"></div>

    {{-- Vite の JS 読み込み --}}
    @viteReactRefresh
    @vite(['resources/js/chat.ts'])
</x-app-layout>
