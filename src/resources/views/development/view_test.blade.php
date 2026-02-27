<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            View Test
        </h2>
    </x-slot>

    {{ Breadcrumbs::render('development.index') }}

    <div class="app-container">
        <form method="POST" action="{{ route('development.view_test_post') }}" class="app-form">
            @csrf
            <div class="mt-5">
                <label for="list_val" class="app-form-label">リスト動作確認</label>

                <select name="list_val" id="list_val">
                    <option value="">選択してください</option>
                    @foreach($list_vals as $key => $value)
                        <option value="{{ $key }}"
                            {{ old('list_val', $list_val) == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-5">
                <label class="app-form-label">ラジオボタン動作確認</label>

                <div class="space-x-3">
                    @foreach($radio_vals as $key => $value)
                        <label>
                            <input type="radio" name="radio_val" value="{{ $key }}"
                                {{ old('radio_val', $radio_val) == $key ? 'checked' : '' }}>
                            {{ $value }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-5">
                <label for="datetime_val" class="app-form-label">日時動作確認</label>
                <input type="datetime-local" name="datetime_val" value="{{ old('datetime_val', $datetime_val) }}" id="datetime_val" />
            </div>

            <div class="mt-5">
                <button type="submit" class="app-btn-primary">送信</button>
            </div>
        </form>
    </div>
</x-app-layout>
