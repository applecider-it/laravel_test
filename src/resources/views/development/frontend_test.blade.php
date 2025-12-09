<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Frontend Test
        </h2>
    </x-slot>

    @vite(['resources/js/entrypoints/development/frontend-test.ts'])

    <div class="py-6 max-w-2xl mx-auto">
        <div id="react-test-root" data-all="{{ json_encode([
            'testValue' => 123,
            'token' => $token,
            'wsHost' => config('myapp.ws_server_host'),
        ]) }}">
            @include('partials.message.loading')
        </div>

        <div id="vue-test-root" data-all="{{ json_encode([
            'testValue' => 456,
        ]) }}" class="mt-10">
            @include('partials.message.loading')
        </div>
    </div>
</x-app-layout>
