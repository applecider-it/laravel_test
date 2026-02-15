@php
$list_val = 2;
$radio_val = 'val2';
$datetime_val = '2026-02-15T14:30';
$list_vals = [
    1 => 'No. 1',
    2 => 'No. 2',
    3 => 'No. 3',
];
$radio_vals = [
    'val1' => 'Value 1',
    'val2' => 'Value 2',
];
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="app-header-title">
            View Test
        </h2>
    </x-slot>

    <div class="app-container">
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
            <input type="datetime-local" value="{{ $datetime_val }}" id="datetime_val" />
        </div>
    </div>
</x-app-layout>
