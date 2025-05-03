<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head />

<body class="font-sans antialiased">
  <div class="min-h-screen bg-base-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
      <header class="bg-white shadow">
        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
          {{ $header }}
        </div>
      </header>
    @endisset

    <!-- Page Content -->
    <main>
      {{ $slot }}
    </main>
  </div>
</body>

</html>
