<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Tweets確認
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <form action="{{ route('tweets.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-3">
                <strong class="my-3">投稿内容:</strong><br>
                <div class="p-5 border-gray-500 border-2">
                    {!! nl2br(e($data['content'])) !!}
                </div>
                <input type="hidden" name="content" value="{{ $data['content'] }}">
            </div>
            <button type="submit" class="mt-2 app-btn-secondary" name="back" value="on">戻る</button>
            <button type="submit" class="mt-2 app-btn-primary" name="commit" value="on">確定</button>

            @include('tweets.partials.hidden')
        </form>

        @include('tweets.partials.index_common')
    </div>
</x-app-layout>
