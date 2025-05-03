<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head />

<body class="font-sans antialiased bg-base-100">
  <x-dashboard.sidebar class="max-w-72" />

  <main class="h-auto md:ml-72">
    <x-dashboard.navbar />

    <div class="container grid gap-6 p-8 max-w-7xl">
      {{ $slot }}
    </div>
  </main>
</body>

</html>
