<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Training Details</x-slot:title>
    <x-slot:description>View training information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card>
    <x-slot:header>
      <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
      <h5>Training Details</h5>
    </x-slot:header>

    <div class="form xl:grid-cols-2">
      <dl>
        <dt class="text-sm font-medium text-base-500">Name</dt>
        <dd>{{ $training->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Department</dt>
        <dd>{{ $training->department->name }}</dd>
      </dl>

      <dl class="col-span-full">
        <dt class="text-sm font-medium text-base-500">Evaluation</dt>
        <dd>{{ $training->evaluation->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Start date</dt>
        <dd>
          <span>{{ $training->start_date->format('d F Y') }}</span>

          @if ($training->start_date > today())
            <span class="text-primary-500">
              ({{ today()->diffInDays($training->start_date) }} days to go)
            </span>
          @endif
        </dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">End date</dt>
        <dd>{{ $training->end_date->format('d F Y') }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Duration</dt>
        <dd>{{ $training->duration }} Hours</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Capacity</dt>
        <dd>{{ $training->target }} Employees</dd>
      </dl>

      <dl class="col-span-full">
        <dt class="text-sm font-medium text-base-500">Description</dt>
        <dd>
          <p>{{ $training->description }}</p>
        </dd>
      </dl>
    </div>

    <x-slot:footer class="justify-end">
      <a href="{{ route('trainings.index') }}">
        <x-ui.button variant="outline" type="button">
          <span>Back</span>
        </x-ui.button>
      </a>

      @can('update', $training)
        <a href="{{ route('trainings.edit', $training) }}">
          <x-ui.button>
            <span>Edit</span>
            <i data-lucide="arrow-up-right" class="size-5"></i>
          </x-ui.button>
        </a>
      @endcan
    </x-slot:footer>
  </x-ui.card>
</x-dashboard-layout>
