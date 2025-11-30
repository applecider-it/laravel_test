<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

<!-- Scripts -->
@viteReactRefresh
@vite(['resources/css/app.css', 'resources/js/app.ts'])

<link rel="manifest" href="/manifest.json">

<meta name="vapid-public-key" content="{{ config('myapp.vapid_public_key') }}">

@auth
    <meta name="user" data-json="{{ json_encode(auth()->user()) }}">
@endauth

<title>{{ config('app.name', 'Laravel') }}</title>
