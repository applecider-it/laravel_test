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
        ]) }}"></div>

        <div id="vue-test-root" data-all="{{ json_encode([
            'testValue' => 456,
        ]) }}" class="mt-10"></div>
    </div>
</x-app-layout>
