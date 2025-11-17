<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Livewire Test
        </h2>
    </x-slot>

    @livewireStyles
    @livewireScripts

    <div class="py-6 max-w-2xl mx-auto">
        <p>
            <livewire:counter />
        </p>
    </div>
</x-app-layout>
