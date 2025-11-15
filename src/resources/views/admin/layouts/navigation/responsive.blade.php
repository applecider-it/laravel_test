<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-100">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
            ユーザー
        </x-responsive-nav-link>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>

        <div class="mt-3 space-y-1">
            <!-- Authentication -->
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('admin.logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</div>
