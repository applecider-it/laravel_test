<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            開発者向けページ
        </h2>
    </x-slot>

    <div class="app-container">
        <p><a href="{{ route('development.php_test') }}" class="app-link-normal">php_test</a></p>
        <p><a href="{{ route('development.view_test') }}" class="app-link-normal">view_test</a></p>
        <p><a href="{{ route('development.javascript_test') }}" class="app-link-normal">javascript_test</a></p>
    </div>
</x-app-layout>
