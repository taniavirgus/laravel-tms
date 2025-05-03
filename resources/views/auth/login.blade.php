<x-guest-layout>
  <x-ui.heading>
    <x-slot:title>Sign in</x-slot:title>
    <x-slot:description>Welcome back! Please enter your details</x-slot:description>
  </x-ui.heading>

  <form method="POST" action="{{ route('login') }}" class="form">
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

    <div class="field">
      <x-ui.label for="password" value="Password" />
      <x-ui.input id="password" type="password" name="password" required autocomplete="current-password"
        placeholder="Enter your password">
        <x-slot:left>
          <i data-lucide="lock" class="text-base-500 size-5"></i>
        </x-slot:left>
      </x-ui.input>
      <x-ui.errors :messages="$errors->get('password')" />
    </div>

    <x-ui.button>
      <span>Log in</span>
      <i data-lucide="arrow-up-right" class="size-5"></i>
    </x-ui.button>

    <p class="text-center">
      Don't have an account? <a href="{{ route('register') }}" class="text-primary-500">Register</a>
    </p>
  </form>
</x-guest-layout>
