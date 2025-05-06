<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Add Employee</x-slot:title>
    <x-slot:description>Create a new employee in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('sysadmin.employees.store') }}">
    <x-slot:header>
      <i data-lucide="user-plus" class="size-5 text-primary-500"></i>
      <h5>Employee Information</h5>
    </x-slot:header>

    @include('dashboard.employees.form')

    <x-slot:footer class="justify-end">
      <a href="{{ route('sysadmin.employees.index') }}">
        <x-ui.button variant="outline" type="button">
          <span>Cancel</span>
        </x-ui.button>
      </a>

      <x-ui.button>
        <span>Create</span>
        <i data-lucide="arrow-up-right" class="size-5"></i>
      </x-ui.button>
    </x-slot:footer>
  </x-ui.card>
</x-dashboard-layout>
