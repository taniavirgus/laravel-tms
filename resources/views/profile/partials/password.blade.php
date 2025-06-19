<div class="grid-cols-2 form">
  <div class="field col-span-full">
    <x-ui.label for="current_password" value="Current Password" />
    <x-ui.input id="current_password" name="current_password" type="password" autocomplete="current-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->get('current_password')" />
  </div>

  <div class="field">
    <x-ui.label for="password" value="New Password" />
    <x-ui.input id="password" name="password" type="password" autocomplete="new-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->get('password')" />
  </div>

  <div class="field">
    <x-ui.label for="password_confirmation" value="Confirm Password" />
    <x-ui.input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-400 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->get('password_confirmation')" />
  </div>
</div>
