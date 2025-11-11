<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tweets
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        @include('tweets.form')

        <div class="space-y-4">
            @include('tweets.list')
        </div>
    </div>
</x-app-layout>
