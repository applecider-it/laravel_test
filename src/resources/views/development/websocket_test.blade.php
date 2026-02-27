<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Websocket Test
        </h2>
    </x-slot>

    {{ Breadcrumbs::render('development.index') }}

    @vite(['resources/js/entrypoints/development/websocket-test.ts'])

    <div class="app-container">
        <div id="vue-test-root" data-all="{{ json_encode([
            'token' => $token,
            'wsHost' => config('myapp.ws_server_host'),
        ]) }}">
            @include('partials.message.loading')
        </div>
    </div>
</x-app-layout>
