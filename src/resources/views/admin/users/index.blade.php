<x-admin-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            ユーザー一覧
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('admin.users.create') }}" class="app-btn-primary">
                新規作成
            </a>

            @if(session('success'))
                <div class="text-green-600 font-medium">{{ session('success') }}</div>
            @endif
        </div>

        
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex space-x-2">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                  placeholder="名前・メールで検索"
                  class="app-search-input">
            <button type="submit" class="app-btn-secondary">
                検索
            </button>
        </form>

        <div class="app-table-container">
            <table class="app-table">
                <thead class="app-table-thead">
                    <tr>
                        <th class="app-table-th">ID</th>
                        <th class="app-table-th">Name</th>
                        <th class="app-table-th">Email</th>
                        <th class="app-table-th">作成日時</th>
                        <th class="app-table-th">退会日時</th>
                        <th class="app-table-th">操作</th>
                    </tr>
                </thead>
                <tbody class="app-table-tbody">
                    @foreach($users as $user)
                        <tr @class(['bg-gray-200' => $user->deleted_at])>
                            <td class="app-table-td">{{ $user->id }}</td>
                            <td class="app-table-td">{{ $user->name }}</td>
                            <td class="app-table-td">{{ $user->email }}</td>
                            <td class="app-table-td">{{ $user->created_at }}</td>
                            <td class="app-table-td">{{ $user->deleted_at }}</td>
                            <td class="app-table-td flex space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="app-btn-primary app-btn-small">
                                    編集
                                </a>
                                @if($user->deleted_at)
                                    <form method="POST" action="{{ route('admin.users.restore', $user) }}" onsubmit="return confirm('復元してもよろしいですか？')">
                                        @csrf
                                        <button type="submit" class="app-btn-orange app-btn-small">
                                            復元
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('削除してもよろしいですか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="app-btn-danger app-btn-small">
                                            削除
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-admin-layout>
