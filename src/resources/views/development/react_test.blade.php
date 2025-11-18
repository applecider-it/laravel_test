<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            React Test
        </h2>
    </x-slot>

    <div id="test-root" data-all="{{ json_encode([
    ]) }}"></div>

    @vite(['resources/js/entrypoints/development/react-test.ts'])
</x-app-layout>
