<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Tweets
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        {{-- React コンポーネントをマウントする場所 --}}
        <div
            id="tweet-app"
            data-all="{{ json_encode([
                'user' => $user,
                'token' => $token,
                'wsHost' => config('myapp.ws_server_host'),
                'tweets' => App\Http\Resources\User\TweetResource::collection($tweets),
            ]) }}">
            @include('partials.message.loading')
        </div>
    </div>
</x-app-layout>

@vite('resources/js/entrypoints/tweet.ts')
