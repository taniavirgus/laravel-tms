<div class="grid-cols-2 form">
  <div class="field col-span-full">
    <x-ui.label for="name" value="Name" />
    <x-ui.input name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name">
      <x-slot:left>
        <i data-lucide="user" class="text-base-400 size-5"></i>
      </x-slot:left>
    </x-ui.input>
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="email" value="Email" />
    <x-ui.input name="email" type="email" :value="old('email', $user->email)" required autocomplete="username">
      <x-slot:left>
        <i data-lucide="mail" class="text-base-400 size-5"></i>
      </x-slot:left>
    </x-ui.input>
    <x-ui.errors :messages="$errors->get('email')" />
  </div>
</div>
