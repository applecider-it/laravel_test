@foreach ($tweets as $tweet)
    <div class="border rounded p-4">
        <p class="text-gray-800">{{ $tweet->content }}</p>
        <p class="text-gray-500 text-sm">by {{ $tweet->user->name }} - {{ $tweet->created_at->diffForHumans() }}</p>
    </div>
@endforeach

<div>
    {{ $tweets->links() }}
</div>
