<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="app-container">
        <div class="my-2">
            <a href="{{ route('development.index') }}" class="app-link-normal">development</a>
        </div>
    </div>
</x-app-layout>
