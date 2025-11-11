<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div id="chat-box"></div>

        <input type="text" id="message">
        <button id="send-btn">Send</button>
    </div>

    {{-- Vite の JS 読み込み --}}
    @vite(['resources/js/chat.js'])

    <script>
        // Laravel から渡される JWT
        window.WS_TOKEN = @json($token);
    </script>
</x-app-layout>
