<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head />

<body class="font-sans antialiased bg-base-100">
  <main class="container grid gap-10 p-8 pb-20 max-w-7xl">
    <x-ui.alert variant="info" status="{{ session('info') }}" />
    <x-ui.alert variant="success" status="{{ session('success') }}" />
    <x-ui.alert variant="warning" status="{{ session('warning') }}" />
    <x-ui.alert variant="error" status="{{ session('error') }}" />
    {{ $slot }}
  </main>
  @stack('scripts')
</body>

</html>
