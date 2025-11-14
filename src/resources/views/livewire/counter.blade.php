<div>
    <h1>{{ $count }}</h1>
    <button wire:click="increment">増やす</button>

    <form wire:submit.prevent="submit">
    <input type="text" wire:model="name" placeholder="名前">
    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

    <input type="email" wire:model="email" placeholder="メールアドレス">
    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror

    <button type="submit">保存</button>
</form>
</div>
