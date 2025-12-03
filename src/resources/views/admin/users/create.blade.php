<x-admin-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            ユーザー作成
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto px-6">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin.users.index') }}" class="app-btn-secondary">
                一覧に戻る
            </a>
        </div>

        @include('partials.form.errors')

        <form method="POST" action="{{ route('admin.users.store') }}" class="app-form">
            @csrf

            <div>
                <label for="name" class="app-form-label">名前</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 app-form-input">
            </div>

            <div>
                <label for="email" class="app-form-label">メールアドレス</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 app-form-input">
            </div>

            <div>
                <label for="password" class="app-form-label">パスワード</label>
                <input type="password" name="password" id="password" class="mt-1 app-form-input">
            </div>

            <div>
                <label for="password_confirmation" class="app-form-label">パスワード確認</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 app-form-input">
            </div>

            <div class="pt-4">
                <button type="submit" class="app-btn-primary">
                    作成
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
