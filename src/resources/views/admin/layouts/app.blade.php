@props(['breadcrumbs' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('admin.layouts.partials.head')
    </head>
    <body class="font-sans antialiased">
        @include('layouts.partials.common')
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('admin.layouts.partials.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-gray-200 dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @isset($breadcrumbs)
                {{ Breadcrumbs::render(...$breadcrumbs) }}
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
