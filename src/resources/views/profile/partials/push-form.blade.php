<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            プッシュ通知
        </h2>
    </header>

    <form method="post" action="{{ route('profile.toggle_push_notification') }}" class="mt-6 space-y-6">
        @csrf

        <div class="flex items-center gap-4">
            <x-primary-button>
                @if ($user->push_notification)
                    無効にする
                @else
                    有効にする
                @endif
            </x-primary-button>

            @if (session('status') === 'push-toggle')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
