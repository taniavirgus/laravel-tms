<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Edit Position</x-slot:title>
    <x-slot:description>Update position information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="POST" action="{{ route('sysadmin.positions.update', $position) }}">
    @method('PUT')

    <x-slot:header>
      <i data-lucide="briefcase" class="size-5 text-primary-500"></i>
      <h4>Position Information</h4>
    </x-slot:header>

    @include('dashboard.positions.form', [
        'position' => $position,
    ])

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
