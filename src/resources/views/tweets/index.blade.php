<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Tweets
        </h2>
    </x-slot>

    @include('partials.message.session')
    @include('partials.message.errors', ['input_error_message' => 'ツイートの入力に問題があります'])

    <div class="py-6 max-w-2xl mx-auto">
        @include('tweets.partials.form')

        <div class="space-y-4">
            @include('tweets.partials.search')
            @include('tweets.partials.list')
        </div>
    </div>
</x-app-layout>
