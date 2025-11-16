<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.ts'])

<link rel="manifest" href="/manifest.json">

<meta name="vapid-public-key" content="{{ env('APP_VAPID_PUBLIC_KEY') }}">

<title>{{ config('app.name', 'Laravel') }}</title>
