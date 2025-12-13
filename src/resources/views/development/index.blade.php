<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            開発者向けページ
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <p><a href="{{ route('development.frontend_test') }}" class="app-link-normal">frontend_test</a></p>
        <p><a href="{{ route('development.backend_test') }}" class="app-link-normal">backend_test</a></p>
    </div>
</x-app-layout>
