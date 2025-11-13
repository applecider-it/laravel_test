<form method="GET" action="{{ route('tweets.index') }}">
  <input type="text" name="search_word" value="{{ $searchWord }}" placeholder="検索ワード">
  <select name="sort">
    <option value="id"   {{ $sort === 'id' ? 'selected' : '' }}>ID</option>
    <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>名前</option>
  </select>
  <select name="sort_type">
    <option value="asc"  {{ $sortType === 'asc' ? 'selected' : '' }}>昇順</option>
    <option value="desc" {{ $sortType === 'desc' ? 'selected' : '' }}>降順</option>
  </select>
  <button type="submit">検索</button>
</form>
