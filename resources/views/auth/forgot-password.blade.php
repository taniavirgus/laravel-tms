<x-guest-layout>
  <x-ui.heading>
    <x-slot:title>Forgot your password?</x-slot:title>
    <x-slot:description>No problem. Just let us know your email address and we will email you a password reset link that
      will allow you to choose a new one.</x-slot:description>
  </x-ui.heading>

  <form method="POST" action="{{ route('password.email') }}" class="form">
    @csrf

    <div class="field">
      <x-ui.label for="email" value="Email" />
      <x-ui.input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
        placeholder="Enter your email">
        <x-slot:left>
          <i data-lucide="mail" class="text-base-500 size-5"></i>
        </x-slot:left>
      </x-ui.input>
      <x-ui.errors :messages="$errors->get('email')" />
    </div>

    <x-ui.button>
      <span>Email Password Reset Link</span>
      <i data-lucide="arrow-up-right" class="size-5"></i>
    </x-ui.button>
  </form>
</x-guest-layout>
