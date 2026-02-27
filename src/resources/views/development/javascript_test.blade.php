<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Javascript Test
        </h2>
    </x-slot>

    {{ Breadcrumbs::render('development.index') }}

    @vite(['resources/js/entrypoints/development/javascript-test.ts'])

    <div class="app-container">
        <div id="vue-test-root" data-all="{{ json_encode([
            'testValue' => 456,
            'formData' => $formData,
        ]) }}">
            @include('partials.message.loading')
        </div>

        <div id="react-test-root" data-all="{{ json_encode([
            'testValue' => 123,
        ]) }}" class="mt-10">
            @include('partials.message.loading')
        </div>

        <div class="my-6 text-lg">読み込み中表示の動作確認</div>
        <div class="mt-5 border-gray-500 border-2 p-0">
            @include('partials.message.loading')
        </div>
        <div class="mt-5 border-gray-500 border-2 p-0">
            @include('partials.message.loading')
        </div>
    </div>
</x-app-layout>
