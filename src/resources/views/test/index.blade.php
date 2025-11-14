<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Test
        </h2>
    </x-slot>

    @livewireStyles
    @livewireScripts

    <div class="py-6 max-w-2xl mx-auto">
        <p><a href="{{ route('test.ai_test') }}" class="app-link-normal">AI Test</a></p>
        <p><a href="{{ route('test.websocket_test') }}" class="app-link-normal">Websocket Test</a></p>

        <p>
            <form action="{{ route('chat.callback_test') }}" method="POST" class="mb-4">
                <button type="submit" class="mt-2 app-btn-primary">chat.callback_test</button>
            </form>
        </p>

        <p>
            <livewire:counter />
        </p>
    </div>
</x-app-layout>
