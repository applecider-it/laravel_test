<x-admin-layout
    :breadcrumbs="['admin.files.create']"
>
    <x-slot name="header">
        <h2 class="app-header-title">
            ファイル作成
        </h2>
    </x-slot>

    <div class="app-container-lg">
        <div class="mb-6">
            <a href="{{ route('admin.files.index') }}" class="app-btn-secondary">
                一覧に戻る
            </a>
        </div>

        @include('partials.form.errors')

        <form method="POST" action="{{ route('admin.files.store') }}" enctype="multipart/form-data" class="app-form">
            @csrf

            @include('admin.files.partials.form')

            <div class="pt-4">
                <button type="submit" class="app-btn-primary">
                    作成
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
