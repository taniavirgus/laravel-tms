<div class="grid gap-6">
  <p class="text-sm text-base-600">
    Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your
    account, please download any data or information that you wish to retain.
  </p>

  <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <x-ui.card as="form" method="post" action="{{ route('profile.destroy') }}">
      @csrf
      @method('delete')

      <x-slot:header>
        <h5>Are you sure you want to delete your account?</h5>
      </x-slot:header>

      <div class="form">
        <p class="text-base-600">
          Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your
          password to confirm you would like to permanently delete your account.
        </p>

        <div>
          <x-ui.input id="password" name="password" type="password" placeholder="Password"
            autocomplete="current-password">
            <x-slot:left>
              <i data-lucide="lock" class="text-base-400 size-5"></i>
            </x-slot:left>
          </x-ui.input>
          <x-ui.errors :messages="$errors->userDeletion->get('password')" />
        </div>
      </div>

      <x-slot:footer>
        <x-ui.button type="button" variant="secondary" x-on:click="$dispatch('close')">
          Cancel
        </x-ui.button>
        <x-ui.button type="submit" variant="destructive" class="ml-2">
          Delete Account
        </x-ui.button>
      </x-slot:footer>
    </x-ui.card>
  </x-modal>
</div>
