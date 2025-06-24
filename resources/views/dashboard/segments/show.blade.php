<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>{{ $segment->label() }} Employees</x-slot:title>
    <x-slot:description>List of employees in {{ $segment->label() }} segment</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="users" class="size-5 text-primary-500"></i>
      <h4>{{ $segment->label() }} Employees</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('talents.show', $segment) }}" method="GET"
        class="flex flex-col gap-2 xl:flex-row xl:items-center">
        <x-ui.input name="search" value="{{ request()->get('search') }}" placeholder="Search by name or description">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('talents.show') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        @can('create', App\Models\TalentTraining::class)
          <a href="{{ route('talents.create', ['segment' => $segment]) }}">
            <x-ui.button>
              <i data-lucide="plus" class="size-5"></i>
              <span>Talent Training</span>
            </x-ui.button>
          </a>
        @endcan

        <a href="{{ route('segments.export', $segment) }}">
          <x-ui.button size="icon" variant="outline" tooltip="Export talent trainings">
            <i data-lucide="download" class="size-5"></i>
          </x-ui.button>
        </a>
      </div>
    </x-slot:action>


    <x-slot:head>
      <x-ui.tooltip id="training" tooltip="Number of training assigned to the employee" />
      <x-ui.tooltip id="evaluation" tooltip="Number of evaluation assigned to the employee" />
      <x-ui.tooltip id="behavior" tooltip="Number of behavior assigned to the employee" />
      <x-ui.tooltip id="potential" tooltip="Average of employee behavior and training score" />
      <x-ui.tooltip id="performance" tooltip="Average of employee evaluation score" />
      <x-ui.tooltip id="average" tooltip="Average of potential and performance score" />

      <th>No</th>
      <th>Name</th>
      <th>Department</th>
      <th data-tooltip-target="training">Training</th>
      <th data-tooltip-target="evaluation">Evaluation</th>
      <th data-tooltip-target="behavior">Behavior</th>
      <th data-tooltip-target="potential">Potential</th>
      <th data-tooltip-target="performance">Performance</th>
      <th data-tooltip-target="average">Average</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($employees as $employee)
        <tr>
          <td class="w-10">{{ $employees->firstItem() + $loop->index }}</td>
          <td>
            <div class="flex items-center gap-2">
              <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
              <span>{{ $employee->name }}</span>
            </div>
          </td>
          <td>{{ $employee->department->name }}</td>
          <td class="font-semibold">{{ $employee->matrix->training_count }}</td>
          <td class="font-semibold">{{ $employee->matrix->evaluation_count }}</td>
          <td class="font-semibold">{{ round($employee->matrix->feedback_score) }}</td>
          <td class="font-semibold">{{ round($employee->matrix->potential_score) }}</td>
          <td class="font-semibold">{{ round($employee->matrix->performance_score) }}</td>
          <td class="font-semibold">{{ round($employee->matrix->average_score) }}</td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('employees.show', $employee) }}" class="text-primary-500">
                View
              </a>
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="10" />
      @endforelse
    </x-slot:body>

    <x-slot:footer class="justify-end">
      <a href="{{ route('segments.index') }}">
        <x-ui.button variant="outline">
          <span>Back</span>
        </x-ui.button>
      </a>
    </x-slot:footer>
  </x-ui.table>

  {{ $employees->links() }}

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="file-text" class="size-5 text-primary-500"></i>
      <h4>{{ $segment->label() }} Trainings</h4>
    </x-slot:title>

    <x-slot:head>
      <th>No</th>
      <th>Title</th>
      <th>Date</th>
      <th>Segment</th>
      <th>Status</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($talents as $talent)
        <tr>
          <td class="w-10">{{ $loop->iteration }}</td>
          <td>{{ $talent->name }}</td>
          <td>
            <div class="flex items-center gap-2">
              <span class="whitespace-nowrap">{{ $talent->start_date->format('F j, Y') }}</span>
              <hr class="w-10 bg-base-500" />
              <span class="whitespace-nowrap">{{ $talent->end_date->format('F j, Y') }}</span>
            </div>
          </td>
          <td><x-ui.badge :value="$talent->segment" /></td>
          <td><x-ui.badge :value="$talent->status" /></td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('talents.show', $talent) }}" class="text-primary-500">
                View
              </a>
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="8" message="No talent trainings assigned to this employee" />
      @endforelse
    </x-slot:body>
  </x-ui.table>
</x-dashboard-layout>
