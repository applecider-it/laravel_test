<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Tweet
        </h2>
    </x-slot>

    @include('partials.message.session')
    @include('partials.message.errors', ['input_error_message' => 'ツイートの入力に問題があります'])

    <div class="py-6 max-w-2xl mx-auto">
        @include('tweet.partials.form')

        @include('tweet.partials.index_common')
    </div>
</x-app-layout>
