@foreach ($tweets as $tweet)
    <div class="border rounded p-4">
        <p class="text-gray-800">{{ $tweet->content }}</p>
        <p class="text-gray-500 text-sm">by {{ $tweet->user->name }} - {{ $tweet->created_at->diffForHumans() }}</p>

        @if ($tweet->user_id === Auth::user()->id)
            <div class="mt-5">
                <form method="POST" action="{{ route('tweet.destroy', $tweet) }}" onsubmit="return confirm('削除してもよろしいですか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="app-btn-danger app-btn-small">
                        削除
                    </button>
                </form>
            </div>
        @endif
    </div>
@endforeach

<div>
    {{ $tweets->links() }}
</div>
