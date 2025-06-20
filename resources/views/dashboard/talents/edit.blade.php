<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Edit Talent Training</x-slot:title>
    <x-slot:description>Update talent training information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('talents.update', $talent) }}" id="talent-form">
    <x-slot:header>
      <i data-lucide="book-open" class="size-5 text-primary-500"></i>
      <h5>Talent Training Information</h5>
    </x-slot:header>

    @csrf
    @method('PUT')
    @include('dashboard.talents.form', [
        'talent' => new App\Models\TalentTraining(),
    ])

    <x-slot:footer class="justify-end">
      <a href="{{ route('talents.index') }}">
        <x-ui.button variant="outline" type="button">
          <span>Cancel</span>
        </x-ui.button>
      </a>

      <x-ui.button type="button" x-data x-on:click="$dispatch('open-modal', 'confirm-update')">
        <span>Update</span>
        <i data-lucide="arrow-up-right" class="size-5"></i>
      </x-ui.button>
    </x-slot:footer>
  </x-ui.card>
</x-dashboard-layout>

<x-modal name="confirm-update" focusable>
  <x-ui.card>
    <x-slot:header>
      <h5 class="text-lg font-semibold text-zinc-900">
        Confirm Talent Training Update
      </h5>
    </x-slot:header>

    <p class="text-zinc-600 text-wrap">
      Warning! this action will update the talent training information,
      <span class="text-red-500">all employees attached to this talent training will be removed</span>
      please make sure to double check the information before proceeding.
    </p>

    <x-slot:footer>
      <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', 'confirm-update')">
        Cancel
      </x-ui.button>

      <x-ui.button type="button" variant="destructive" x-data
        x-on:click="document.getElementById('talent-form').submit()">
        Confirm Update
      </x-ui.button>
    </x-slot:footer>
  </x-ui.card>
</x-modal>
