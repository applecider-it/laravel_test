<x-filament-panels::page>
    <h2>ユーザー: {{ $this->user->name }}</h2>

    <p>Email: {{ $this->user->email }}</p>

    <x-filament::button
        type="button"
        style="width: 20rem"
        x-on:click="if(confirm('本当に実行しますか？')) { $wire.performAction() }"
    >
        カスタムアクションを実行
    </x-filament::button>
</x-filament-panels::page>
