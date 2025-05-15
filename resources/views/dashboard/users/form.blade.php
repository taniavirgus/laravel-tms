<div class="xl:grid-cols-2 form">
  <div class="field col-span-full">
    <x-ui.label for="name" value="Full Name" /> <x-ui.input id="name" name="name" type="text"
      value="{{ old('name', $user->name) }}" required autofocus />
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="email" value="Email Address" /> <x-ui.input id="email" name="email" type="email"
      value="{{ old('email', $user->email) }}" required />
    <x-ui.errors :messages="$errors->get('email')" />
  </div>

  <div class="field">
    <x-ui.label for="password" value="Password" />
    <x-ui.input id="password" name="password" type="password" :required="!isset($user->id)">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-500 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->get('password')" />

    @if (isset($user->id) && !$errors->has('password'))
      <p class="text-sm text-base-500">Leave blank to keep the current password</p>
    @endif
  </div>

  <div class="field">
    <x-ui.label for="password_confirmation" value="Confirm Password" />
    <x-ui.input id="password_confirmation" name="password_confirmation" type="password" :required="!isset($user->id)">
      <x-slot:right>
        <i data-lucide="lock" class="text-base-500 size-5"></i>
      </x-slot:right>
    </x-ui.input>
    <x-ui.errors :messages="$errors->get('password_confirmation')" />
  </div>

  <div class="field">
    <x-ui.label for="role" value="User Role" />
    <x-ui.select id="role" name="role" required>
      <option value="">Select Role</option>
      @foreach ($roles as $role)
        <option value="{{ $role->value }}" @selected(old('role', $user->role?->value) === $role->value)>
          {{ $role->label() }}
        </option>
      @endforeach
    </x-ui.select>
    <x-ui.errors :messages="$errors->get('role')" />
  </div>
</div>
