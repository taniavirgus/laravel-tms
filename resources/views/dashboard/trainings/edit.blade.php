<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Edit Training</x-slot:title>
    <x-slot:description>Update training information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('trainings.update', $training) }}">
    <x-slot:header>
      <i data-lucide="book-open" class="size-5 text-primary-500"></i>
      <h5>Training Information</h5>
    </x-slot:header>

    @csrf
    @method('PUT')
    @include('dashboard.trainings.form', [
        'training' => $training,
    ])

    <x-slot:footer class="justify-end">
      <a href="{{ route('trainings.index') }}">
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
