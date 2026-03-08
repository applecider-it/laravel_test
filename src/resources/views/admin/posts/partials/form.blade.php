@vite('resources/js/entrypoints/admin/post-edit.ts')

<div>
    <label for="title" class="app-form-label">タイトル</label>
    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="mt-1 app-form-input">
    @error('title')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="slug" class="app-form-label">Slug</label>
    <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" class="mt-1 app-form-input">
    @error('slug')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="content" class="app-form-label">内容 (markdown)</label>
    <textarea id="editor" name="content" rows="15" class="mt-1 app-form-input">{{ old('content', $post->content) }}</textarea>
    @error('content')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="content" class="app-form-label">プレビュー</label>
    <div id="preview" class="app-post-content-container border p-5 overflow-y-scroll" style="height: 20rem;">
    </div>
</div>

<div>
    <label for="published_at" class="app-form-label">投稿日時</label>
    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $post->published_at) }}" class="mt-1 app-form-input w-auto">
    @error('published_at')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>
