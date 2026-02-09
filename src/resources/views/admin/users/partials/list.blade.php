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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
