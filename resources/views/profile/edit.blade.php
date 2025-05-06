<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Profile</x-slot:title>
    <x-slot:description>Update your account's profile information and email address.</x-slot:description>
  </x-dashboard.heading>

  <div class="grid items-start grid-cols-2 gap-6">
    <x-ui.card as="form" method="post" action="{{ route('profile.update') }}">
      <x-slot:header>
        <h5>Profile Information</h5>
      </x-slot:header>

      @csrf
      @method('patch')
      @include('profile.partials.update')

      <x-slot:footer>
        <x-ui.button>
          <span>Save</span>
          <i data-lucide="arrow-up-right" class="size-5"></i>
        </x-ui.button>
      </x-slot:footer>
    </x-ui.card>

    <x-ui.card as="form" method="post" action="{{ route('password.update') }}">
      <x-slot:header>
        <h5>Update Password</h5>
      </x-slot:header>

      @csrf
      @method('put')
      @include('profile.partials.password')

      <x-slot:footer>
        <x-ui.button>
          <span>Update</span>
          <i data-lucide="arrow-up-right" class="size-5"></i>
        </x-ui.button>
      </x-slot:footer>
    </x-ui.card>

    <x-ui.card class="col-span-full">
      <x-slot:header>
        <h5>Delete Account</h5>
      </x-slot:header>

      @include('profile.partials.delete')

      <x-slot:footer>
        <x-ui.button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
          variant="destructive">
          Delete Account
        </x-ui.button>
      </x-slot:footer>
    </x-ui.card>
  </div>
</x-dashboard-layout>
