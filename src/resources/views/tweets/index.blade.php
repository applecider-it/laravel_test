<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tweets
        </h2>
    </x-slot>

    @include('partials.message', ['input_error_message' => 'ツイートの入力に問題があります'])

    <div class="py-6 max-w-2xl mx-auto">

        @include('tweets.partials.form')

        <div class="space-y-4">
            @include('tweets.partials.search')
            @include('tweets.partials.list')
        </div>
    </div>
</x-app-layout>
