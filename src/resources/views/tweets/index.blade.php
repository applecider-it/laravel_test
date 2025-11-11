<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tweets
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <form action="{{ route('tweets.store') }}" method="POST" class="mb-4">
            @csrf
            <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="What's happening?"></textarea>
            @error('content')
                <p class="app-error-text">{{ $message }}</p>
            @enderror
            <button type="submit" class="mt-2 app-btn-primary">Tweet</button>
        </form>

        <div class="space-y-4">
            @foreach ($tweets as $tweet)
                <div class="border rounded p-4">
                    <p class="text-gray-800">{{ $tweet->content }}</p>
                    <p class="text-gray-500 text-sm">by {{ $tweet->user->name }} - {{ $tweet->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
