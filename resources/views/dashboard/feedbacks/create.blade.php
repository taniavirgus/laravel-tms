<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Add Feedback</x-slot:title>
    <x-slot:description>Create feedback for employee {{ $employee->name }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('employees.feedback.store', $employee->id) }}">
    <x-slot:header>
      <i data-lucide="check-circle" class="size-5 text-primary-500"></i>
      <h5>Feedback Form</h5>
    </x-slot:header>

    @csrf
    @include('dashboard.feedbacks.form', [
        'feedback' => $employee->feedback,
    ])

    <x-slot:footer class="justify-end">
      <a href="{{ route('employees.show', $employee->id) }}">
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
