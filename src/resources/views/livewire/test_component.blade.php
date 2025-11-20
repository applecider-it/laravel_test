<div>
    <div class="border-red-500">
        <div app="app-h3">{{ $count }}</div>
        <button wire:click="increment" class="app-btn-secondary">増やす</button>
    </div>

    <div>id: {{ $id }}</div>
    <div>time: {{ date('h:i:s') }}</div>

    <form wire:submit.prevent="submit">
        <input type="text" wire:model="name" placeholder="名前" class="app-form-input">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

        <input type="text" wire:model="email" placeholder="メールアドレス" class="app-form-input">
        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror

        <div>
            <button type="submit" class="app-btn-primary">保存</button>
        </div>
    </form>

    <div>
        <div>
            @foreach ($tweets as $tweet)
                <div>{{ $tweet->content }}</div>
            @endforeach
        </div>
    
        {{ $tweets->links() }}
    </div>
</div>
