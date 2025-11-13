<form action="{{ route('tweets.store') }}" method="POST" class="mb-4">
    @csrf
    <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="What's happening?">{{ old('content') }}</textarea>
    @error('content')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
    <button type="submit" class="mt-2 app-btn-primary">Tweet</button>
</form>