<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head />

<body class="font-sans antialiased">
  <div class="container grid h-screen max-w-7xl place-items-center">
    <div class="flex flex-col justify-center gap-6 text-center">
      <h1 class="text-6xl font-bold truncate text-zinc-900">
        {{ $exception->getMessage() }}
      </h1>

      <p class="text-zinc-600 text-wrap">
        Unfortunately, it appears that your current account does not have the necessary permissions to access this
        particular page or perform the requested action. If you believe this is an error or you require access, please
        contact your system administrator or support team for further assistance. In the meantime, you may return to the
        previous page or navigate to another section of the application.
      </p>

      <div class="flex justify-center gap-4">
        <a href="{{ url()->previous() }}">
          <x-ui.button variant="secondary">
            <i data-lucide="arrow-left" class="size-4"></i>
            <span>Back</span>
          </x-ui.button>
        </a>

        <a href="{{ route('dashboard') }}">
          <x-ui.button>
            <i data-lucide="box" class="size-4"></i>
            <span>Dashboard</span>
          </x-ui.button>
        </a>
      </div>
    </div>
  </div>
</body>

</html>
