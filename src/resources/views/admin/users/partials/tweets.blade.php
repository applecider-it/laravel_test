<h3 class="my-5">
    ツイート一覧
</h3>

<div>
    <div class="app-table-container">
        <table class="app-table">
            <thead class="app-table-thead">
                <tr>
                    <th class="app-table-th">ID</th>
                    <th class="app-table-th">Content</th>
                    <th class="app-table-th">作成日時</th>
                    <th class="app-table-th">削除日時</th>
                </tr>
            </thead>
            <tbody class="app-table-tbody">
                @foreach($tweets as $tweet)
                    <tr>
                        <td class="app-table-td">{{ $tweet->id }}</td>
                        <td class="app-table-td">{{ $tweet->content }}</td>
                        <td class="app-table-td">{{ $tweet->created_at }}</td>
                        <td class="app-table-td">{{ $tweet->deleted_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tweets->links() }}
    </div>
</div>
