<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            開発者向けページ
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <p><a href="{{ route('development.php_test') }}" class="app-link-normal">php_test</a></p>
        <p><a href="{{ route('development.javascript_test') }}" class="app-link-normal">javascript_test</a></p>
    </div>
</x-app-layout>
