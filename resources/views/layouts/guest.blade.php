<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head />

<body class="font-sans antialiased">
  <div class="grid lg:grid-cols-2 xl:grid-cols-3">
    <div class="relative items-center hidden xl:col-span-2 lg:grid bg-gradient-to-t from-primary-900 to-primary-600">
      <div class="container relative flex flex-col w-full max-w-4xl gap-2 mx-auto text-white">
        <h1 class="text-5xl font-bold">PT <span class="text-yellow-400">MNC</span> Tbk.</h1>
        <span class="text-2xl"> Talent Management System</span>
      </div>
    </div>

    <div class="relative grid items-center h-screen overflow-y-auto">
      <div class="absolute top-0 right-0 p-10">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32" />
      </div>

      <div class="container grid max-w-lg gap-6">
        <x-ui.alert variant="info" status="{{ session('info') }}" />
        <x-ui.alert variant="success" status="{{ session('success') }}" />
        <x-ui.alert variant="warning" status="{{ session('warning') }}" />
        <x-ui.alert variant="error" status="{{ session('error') }}" />

        {{ $slot }}
      </div>
    </div>
  </div>
</body>

</html>
