<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>{{ $segment ? $segment->label() : 'Add' }} Talent Training</x-slot:title>
    <x-slot:description>Create a new talent training in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('talents.store') }}">
    <x-slot:header>
      <i data-lucide="book-open" class="size-5 text-primary-500"></i>
      <h5>Talent Training Information</h5>
    </x-slot:header>

    @csrf
    @include('dashboard.talents.form', [
        'talent' => new App\Models\TalentTraining(),
    ])

    <x-slot:footer class="justify-end">
      <a href="{{ route('talents.index') }}">
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
