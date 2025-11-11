<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <div id="chat-box"></div>
        <input type="text" id="message">
        <button onclick="sendMessage()">Send</button>

        <script>
        const WS_TOKEN = @json($token);
        const ws = new WebSocket(`ws://127.0.0.1:8080?token=${WS_TOKEN}`);

        ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            const box = document.getElementById('chat-box');
            box.innerHTML += `<p><strong>${data.user}:</strong> ${data.message}</p>`;
        };

        function sendMessage() {
            const message = document.getElementById('message').value;
            ws.send(JSON.stringify({ message }));
            document.getElementById('message').value = '';
        }
        </script>

    </div>
</x-app-layout>
