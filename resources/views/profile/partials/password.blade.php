<div class="form">
  <div class="field">
    <x-ui.label for="update_password_current_password" value="Current Password" />
    <x-ui.input id="update_password_current_password" name="current_password" type="password"
      autocomplete="current-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->updatePassword->get('current_password')" />
  </div>

  <div class="field">
    <x-ui.label for="update_password_password" value="New Password" />
    <x-ui.input id="update_password_password" name="password" type="password" autocomplete="new-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->updatePassword->get('password')" />
  </div>

  <div class="field">
    <x-ui.label for="update_password_password_confirmation" value="Confirm Password" />
    <x-ui.input id="update_password_password_confirmation" name="password_confirmation" type="password"
      autocomplete="new-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->updatePassword->get('password_confirmation')" />
  </div>
</div>
