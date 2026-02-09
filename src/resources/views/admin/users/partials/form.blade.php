<div>
    <label for="name" class="app-form-label">名前</label>
    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 app-form-input">
    @error('name')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="email" class="app-form-label">メールアドレス</label>
    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 app-form-input">
    @error('email')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="password" class="app-form-label">
        パスワード
        @if($user->exists)
            （変更する場合のみ）
        @endif
    </label>
    <input type="password" name="password" id="password" class="mt-1 app-form-input">
    @error('password')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="password_confirmation" class="app-form-label">パスワード確認</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 app-form-input">
    @error('password_confirmation')
        <p class="app-error-text">{{ $message }}</p>
    @enderror
</div>
