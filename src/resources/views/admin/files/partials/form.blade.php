
<div>
    <label for="title" class="app-form-label">ファイル</label>
    <input type="file" name="file">
    @error('file')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>
