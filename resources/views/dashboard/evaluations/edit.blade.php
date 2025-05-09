<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Edit Evaluation</x-slot:title>
    <x-slot:description>Update evaluation information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('evaluations.update', $evaluation) }}">
    @method('PUT')
    <x-slot:header>
      <i data-lucide="check-circle" class="size-5 text-primary-500"></i>
      <h5>Evaluation Information</h5>
    </x-slot:header>

    @include('dashboard.evaluations.form')

    <x-slot:footer class="justify-end">
      <a href="{{ route('evaluations.index') }}">
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
