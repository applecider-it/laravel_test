<x-admin-layout
    :breadcrumbs="['admin.files.index']"
>
    <x-slot name="header">
        <h2 class="app-header-title">
            ファイル一覧
        </h2>
    </x-slot>

    <div class="app-container-lg">
        <div class="mb-4">
            <a href="{{ route('admin.files.create') }}" class="app-btn-primary">
                新規作成
            </a>
        </div>

        @include('partials.message.session')

        @include('admin.files.partials.list')

        <div class="mt-4">
            {{ $files->links() }}
        </div>
    </div>
</x-admin-layout>
