<x-blank-layout>
    <header>
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="app-btn-primary"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="app-btn-primary"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="app-btn-primary">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>
</x-blank-layout>
