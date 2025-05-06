<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Edit Department</x-slot:title>
    <x-slot:description>Update department information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('sysadmin.departments.update', $department) }}">
    <x-slot:header>
      <i data-lucide="building2" class="size-5 text-primary-500"></i>
      <h5>Department Information</h5>
    </x-slot:header>

    @csrf
    @method('put')
    @include('dashboard.departments.form')

    <x-slot:footer class="justify-end">
      <a href="{{ route('sysadmin.departments.index') }}">
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
