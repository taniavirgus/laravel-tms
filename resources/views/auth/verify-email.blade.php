<x-guest-layout>
  <x-ui.heading>
    <x-slot:title>Verify Email Address</x-slot:title>
    <x-slot:description>Thanks for signing up! Before getting started, could you verify your email address by clicking
      on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</x-slot:description>
  </x-ui.heading>


  <form method="POST" action="{{ route('verification.send') }}">
    @csrf

    <div class="flex items-center justify-between mt-4">
      <x-ui.button>
        <span>Resend Verification Email</span>
        <i data-lucide="arrow-up-right" class="size-5"></i>
      </x-ui.button>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-ui.button variant="destructive">
          Log Out
        </x-ui.button>
      </form>
    </div>
  </form>
</x-guest-layout>
