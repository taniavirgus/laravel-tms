<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Edit User</x-slot:title>
    <x-slot:description>Update user information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('users.update', $user) }}">
    @method('PUT')
    <x-slot:header>
      <i data-lucide="user-cog" class="size-5 text-primary-500"></i>
      <h5>User Information</h5>
    </x-slot:header>

    @include('dashboard.users.form')

    <x-slot:footer class="justify-end">
      <a href="{{ route('users.index') }}">
        <x-ui.button variant="outline" type="button">
          <span>Cancel</span>
        </x-ui.button>
      </a>

      <x-ui.button>
        <span>Update</span>
        <i data-lucide="arrow-up-right" class="size-5"></i>
      </x-ui.button>
    </x-slot:footer>
  </x-ui.card>
</x-dashboard-layout>
