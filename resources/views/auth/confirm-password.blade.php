<x-guest-layout>
  <x-ui.heading>
    <x-slot:title>Confirm Password</x-slot:title>
    <x-slot:description>Please confirm your password before continuing</x-slot:description>
  </x-ui.heading>

  <form method="POST" action="{{ route('password.confirm') }}" class="form">
    @csrf

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
      <span>Confirm</span>
      <i data-lucide="arrow-up-right" class="size-5"></i>
    </x-ui.button>
  </form>
</x-guest-layout>
