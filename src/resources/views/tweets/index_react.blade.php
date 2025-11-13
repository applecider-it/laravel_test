<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tweets
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        {{-- React コンポーネントをマウントする場所 --}}
        <div id="tweet-app" data-tweets="{{ $tweets->toJson() }}" data-user="{{ auth()->user() }}"></div>
    </div>
</x-app-layout>

@viteReactRefresh
@vite('resources/js/tweet.ts')
