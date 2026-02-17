<x-admin-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            ユーザー編集
        </h2>
    </x-slot>

    <div class="app-container-lg">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="app-btn-secondary">
                一覧に戻る
            </a>
        </div>

        @include('partials.form.errors')

        @include('partials.message.session')

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="app-form">
            @csrf
            @method('PUT')

            @include('admin.users.partials.form')

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

        <div class="my-5">
            <div>
                @include('admin.users.partials.tweets')
            </div>
        </div>

        <div class="mt-20">
            <div class="flex justify-between items-center">
                <div>
                    ユーザー論理削除
                </div>
                <div>
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
        </div>
    </div>
</x-admin-layout>
