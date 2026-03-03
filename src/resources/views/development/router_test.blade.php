<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Router Test
        </h2>
    </x-slot>

    @vite(['resources/js/entrypoints/development/router-test.ts'])

    <div class="app-container">
        <div id="test-root" data-all="{{ json_encode([
            'name' => $name,
        ]) }}">
            @include('partials.message.loading')
        </div>
    </div>
</x-app-layout>
