<x-admin-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            ユーザー編集
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.users.index') }}" class="app-btn-secondary">
                一覧に戻る
            </a>
            @if(session('success'))
                <div class="text-green-600 font-medium">{{ session('success') }}</div>
            @endif
        </div>
    </div>

    <div class="max-w-3xl mx-auto">
        @include('partials.form.errors')

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="app-form">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="app-form-label">名前</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 app-form-input">
            </div>

            <div>
                <label for="email" class="app-form-label">メールアドレス</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 app-form-input">
            </div>

            <div>
                <label for="password" class="app-form-label">パスワード（変更する場合のみ）</label>
                <input type="password" name="password" id="password" class="mt-1 app-form-input">
            </div>

            <div>
                <label for="password_confirmation" class="app-form-label">パスワード確認</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 app-form-input">
            </div>

            <div>
                <label for="name" class="app-form-label">更新日時</label>
                {{ $user->updated_at }}
            </div>

            <div>
                <label for="name" class="app-form-label">削除日時</label>
                {{ $user->deleted_at }}
            </div>

            <div class="pt-4">
                <button type="submit" class="app-btn-primary">
                    更新
                </button>
            </div>
        </form>
    </div>

    <div class="py-12 max-w-7xl mx-auto">
        <div>
            @include('admin.users.partials.tweets')
        </div>
    </div>

    <div class="max-w-3xl mx-auto py-20">
        <div class="">
            @if($user->deleted_at)
                <form method="POST" action="{{ route('admin.users.restore', $user) }}" onsubmit="return confirm('復元してもよろしいですか？')">
                    @csrf
                    <button type="submit" class="app-btn-orange">
                        復元
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('削除してもよろしいですか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="app-btn-danger">
                        削除
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-admin-layout>
