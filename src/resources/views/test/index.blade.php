<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Test
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <p><a href="{{ route('test.ai_test') }}" class="app-link-normal">AI Test</a></p>
        <p><a href="{{ route('test.websocket_test') }}" class="app-link-normal">Websocket Test</a></p>
        <p><a href="{{ route('test.livewire_test') }}" class="app-link-normal">livewire_test</a></p>
        <p><a href="{{ route('test.backend_test') }}" class="app-link-normal">backend_test</a></p>
    </div>
</x-app-layout>
