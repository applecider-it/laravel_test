<div class="app-table-container">
    <table class="app-table">
        <thead class="app-table-thead">
            <tr>
                <th class="app-table-th">ID</th>
                <th class="app-table-th">ファイル名</th>
                <th class="app-table-th">URL</th>
                <th class="app-table-th">作成日時</th>
                <th class="app-table-th">操作</th>
            </tr>
        </thead>
        <tbody class="app-table-tbody">
            @foreach($files as $file)
                <tr>
                    <td class="app-table-td">{{ $file->id }}</td>
                    <td class="app-table-td">{{ $file->file_name }}</td>
                    <td class="app-table-td text-xs">{{ $file->fileUrl() }}</td>
                    <td class="app-table-td">{{ $file->created_at }}</td>
                    <td class="app-table-td flex space-x-2">
                        <form method="POST" action="{{ route('admin.files.destroy', $file) }}" onsubmit="return confirm('削除してもよろしいですか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="app-btn-danger">
                                削除
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
