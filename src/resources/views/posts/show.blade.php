<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            投稿
        </h2>
    </x-slot>

    <div class="app-container">
        <div class="space-y-4">
            <div>
                {{ $post->title }}
            </div>
            <div>
                {{ $post->published_at }}
            </div>
            <div class="app-post-content-container">
                {!! $post->contentHtml() !!}
            </div>
        </div>
    </div>
</x-app-layout>
