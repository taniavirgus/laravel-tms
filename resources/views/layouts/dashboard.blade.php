<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-zinc-100 text-zinc-700">
  <x-dashboard.navbar />

  <x-dashboard.sidebar class="px-4 pt-20 max-w-72" />

  <main class="h-auto pt-16 sm:ml-72">
    <div class="container py-8 max-w-7xl">
      {{ $slot }}
    </div>
  </main>
</body>

</html>
