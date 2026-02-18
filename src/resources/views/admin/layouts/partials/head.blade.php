<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

<!-- Scripts -->
@viteReactRefresh
@vite(['resources/css/admin.css', 'resources/js/entrypoints/admin/app.ts'])

@auth('admin')
    <meta name="user" data-json="{{ json_encode(auth('admin')->user()) }}">
@endauth

<title>{{ config('app.name', 'Laravel') }}管理画面</title>
