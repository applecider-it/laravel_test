<x-admin-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            ユーザー一覧
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('admin.users.create') }}" class="app-btn-primary">
                新規作成
            </a>
        </div>
        
        @include('admin.users.partials.search')

        @include('admin.users.partials.list')

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>
