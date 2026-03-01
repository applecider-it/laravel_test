@php
$blockStyle = "border-gray-400 border-2 p-3";
@endphp
<div class="py-6 border-gray-500 border-2 p-5">
    <div class="mb-6 text-lg">htmx動作確認</div>

    <div class="space-y-4">
        <div class="{{ $blockStyle }}">
            <div id="htmx_test_result">
                <button
                    hx-post="{{ route('development.htmx_test') }}"
                    hx-target="#htmx_test_result"
                    hx-swap="innerHTML"
                    hx-confirm="本当に実行しますか？"
                    class="app-btn-primary"
                >
                    クリック
                </button>
            </div>
        </div>
    </div>
</div>