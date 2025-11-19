<x-admin-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            ユーザー編集
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.users.index') }}" class="app-btn-secondary">
                一覧に戻る
            </a>
        </div>
    </div>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

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

            <div class="pt-4">
                <button type="submit" class="app-btn-primary">
                    更新
                </button>
            </div>
        </form>
    </div>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
            @include('admin.users.partials.tweets')
        </div>
    </div>
</x-admin-layout>
