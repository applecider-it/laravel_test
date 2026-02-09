<form method="GET" action="{{ route('admin.users.index') }}" class="flex space-x-2">
    <input type="text" name="search" value="{{ $search ?? '' }}"
            placeholder="名前・メールで検索"
            class="app-search-input">
    <button type="submit" class="app-btn-secondary">
        検索
    </button>
</form>