<x-guest-layout>
  <x-ui.heading>
    <x-slot:title>Sign up</x-slot:title>
    <x-slot:description>Create an account to get started</x-slot:description>
  </x-ui.heading>

  <form method="POST" action="{{ route('register') }}" class="form">
    @csrf

    <div class="field">
      <x-ui.label for="name" value="Name" />
      <x-ui.input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
        placeholder="Enter your name">
        <x-slot:left>
          <i data-lucide="user" class="text-base-500 size-5"></i>
        </x-slot:left>
      </x-ui.input>
      <x-ui.errors :messages="$errors->get('name')" />
    </div>

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
      <x-ui.input id="password" type="password" name="password" required autocomplete="new-password"
        placeholder="Enter your password">
        <x-slot:left>
          <i data-lucide="lock" class="text-base-500 size-5"></i>
        </x-slot:left>
      </x-ui.input>
      <x-ui.errors :messages="$errors->get('password')" />
    </div>

    <div class="field">
      <x-ui.label for="password_confirmation" value="Confirm Password" />
      <x-ui.input id="password_confirmation" type="password" name="password_confirmation" required
        autocomplete="new-password" placeholder="Confirm your password">
        <x-slot:left>
          <i data-lucide="lock" class="text-base-500 size-5"></i>
        </x-slot:left>
      </x-ui.input>
      <x-ui.errors :messages="$errors->get('password_confirmation')" />
    </div>

    <x-ui.button>
      <span>Register</span>
      <i data-lucide="arrow-up-right" class="size-5"></i>
    </x-ui.button>

    <p class="text-center">
      Already have an account? <a href="{{ route('login') }}" class="text-primary-500">Log in</a>
    </p>
  </form>
</x-guest-layout>
