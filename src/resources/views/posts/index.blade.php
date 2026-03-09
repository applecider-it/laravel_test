<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            投稿
        </h2>
    </x-slot>

    <div class="app-container">
        <div class="space-y-4">
            @foreach ($posts as $post)
                <div class="border border-black cursor-pointer block bg-white rounded-2xl shadow hover:shadow-xl transition p-6"
                    data-href="{{ route('posts.show', ['slug' => $post->slug]) }}" onclick="location.href = this.dataset.href"
                >
                    <div class="p-4 text-lg">{{ $post->title }}</div>
                    <div class="p-4 text-sm text-gray-400">{{ Str::limit($post->contentText(), 50) }}</div>
                    <div class="text-sm text-gray-400 text-right">{{ $post->published_at }}</div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
