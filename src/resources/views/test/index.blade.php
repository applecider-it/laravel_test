<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Test
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <p>
            <a href="{{ route('test.ai_test') }}">
                AI Test
            </a>
        </p>
    </div>
</x-app-layout>
