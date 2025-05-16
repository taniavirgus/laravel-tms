<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Edit Training</x-slot:title>
    <x-slot:description>Update training information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('trainings.update', $training) }}" id="training-form">
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
        Confirm Training Update
      </h5>
    </x-slot:header>

    <p class="text-zinc-600 text-wrap">
      Warning! this action will update the training information,
      <span class="text-red-500">all employees attached to this training will be removed</span>
      please make sure to double check the information before proceeding.
    </p>

    <x-slot:footer>
      <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', 'confirm-update')">
        Cancel
      </x-ui.button>

      <x-ui.button type="button" variant="destructive" x-data
        x-on:click="document.getElementById('training-form').submit()">
        Confirm Update
      </x-ui.button>
    </x-slot:footer>
  </x-ui.card>
</x-modal>
