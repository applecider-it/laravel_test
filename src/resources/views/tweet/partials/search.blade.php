<form method="GET" action="{{ route('tweet.index') }}">
  <input type="text" name="search_word" value="{{ $searchWord }}" placeholder="検索ワード">
  <button type="submit">検索</button>
</form>
