<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            Tweets
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <form action="{{ route('tweets.store') }}" method="POST" class="mb-4">
            @csrf
            <div>
                <strong>投稿内容:</strong><br>
                {!! nl2br(e($data['content'])) !!}
                <input type="hidden" name="content" value="{{ $data['content'] }}">
            </div>
            <input type="hidden" name="commit" value="yes!!">
            <button type="submit" class="mt-2 app-btn-primary">Commit!!</button>
        </form>
    </div>
</x-app-layout>
