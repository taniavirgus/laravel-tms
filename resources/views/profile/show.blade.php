<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Profile</x-slot:title>
    <x-slot:description>Account's profile information and email address.</x-slot:description>
  </x-dashboard.heading>

  <div class="grid items-start gap-6">
    <x-ui.card>
      <x-slot:header>
        <h5>Profile Information</h5>
      </x-slot:header>

      <div class="grid-cols-2 form">
        <div class="field">
          <x-ui.label for="name" value="Name" />
          <x-ui.input readonly name="name" type="text" value="{{ $user->name }}">
            <x-slot:left>
              <i data-lucide="user" class="text-base-400 size-5"></i>
            </x-slot:left>
          </x-ui.input>
        </div>

        <div class="field">
          <x-ui.label for="role" value="Role" />
          <div>
            <x-ui.badge :value="$user->role" />
          </div>
        </div>

        <div class="field col-span-full">
          <x-ui.label for="email" value="Email" />
          <x-ui.input readonly name="email" type="email" value="{{ $user->email }}">
            <x-slot:left>
              <i data-lucide="mail" class="text-base-400 size-5"></i>
            </x-slot:left>
          </x-ui.input>
        </div>

        <div class="field">
          <x-ui.label for="created_at" value="Created At" />
          <x-ui.input readonly name="created_at" type="date" value="{{ $user->created_at->format('Y-m-d') }}">
            <x-slot:left>
              <i data-lucide="calendar" class="text-base-400 size-5"></i>
            </x-slot:left>
          </x-ui.input>
        </div>

        <div class="field">
          <x-ui.label for="updated_at" value="Updated At" />
          <x-ui.input readonly name="updated_at" type="date" value="{{ $user->updated_at->format('Y-m-d') }}">
            <x-slot:left>
              <i data-lucide="calendar" class="text-base-400 size-5"></i>
            </x-slot:left>
          </x-ui.input>
        </div>
      </div>

      <x-slot:footer class="justify-end">
        <a href="{{ route('profile.edit') }}">
          <x-ui.button>
            <span>Edit Profile</span>
            <i data-lucide="arrow-up-right" class="size-5"></i>
          </x-ui.button>
        </a>
      </x-slot:footer>
    </x-ui.card>
  </div>
</x-dashboard-layout>
