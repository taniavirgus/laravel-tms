<form method="post" action="{{ route('password.update') }}" class="form">
  @csrf
  @method('put')

  <div>
    <x-ui.label for="update_password_current_password" value="Current Password" />
    <x-ui.input id="update_password_current_password" name="current_password" type="password"
      autocomplete="current-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
  </div>

  <div>
    <x-ui.label for="update_password_password" value="New Password" />
    <x-ui.input id="update_password_password" name="password" type="password" autocomplete="new-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->updatePassword->get('password')" class="mt-2" />
  </div>

  <div>
    <x-ui.label for="update_password_password_confirmation" value="Confirm Password" />
    <x-ui.input id="update_password_password_confirmation" name="password_confirmation" type="password"
      autocomplete="new-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />

  </div>

  <div class="flex items-center gap-4">
    <x-ui.button>Save</x-ui.button>
    @if (session('status') === 'password-updated')
      <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-base-600">
        Saved.</p>
    @endif
  </div>
</form>
