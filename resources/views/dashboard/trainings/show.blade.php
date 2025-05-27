@php
  use App\Enums\BooleanType;
  use App\Enums\AssignmentType;
@endphp

<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>{{ $training->name }} training</x-slot:title>
    <x-slot:description>{{ $training->description }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card>
    <x-slot:header>
      <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
      <h5>Training Details</h5>
    </x-slot:header>

    <div class="xl:grid-cols-4 form">
      <div class="col-span-2">
        <label class="text-sm font-medium text-base-500">Start date</label>
        <div class="text-4xl font-bold">
          {{ $training->start_date->format('F jS, Y') }}
        </div>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Type</label>
        <div><x-ui.badge :value="$training->type" /></div>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Status</label>
        <div><x-ui.badge :value="$training->status" /></div>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Duration</label>
        <span class="block">{{ $training->duration }} Hours</span>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Date End</label>
        <span class="block">{{ $training->end_date->format('F jS, Y') }}</span>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Capacity</label>
        <span class="block">{{ $training->capacity }} Employees</span>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Participants</label>
        <span @class([
            'block',
            'text-red-500' => $assigned->count() == $training->capacity,
        ])>
          {{ $assigned->count() }} Employees
        </span>
      </div>

      <div class="col-span-2">
        <label class="text-sm font-medium text-base-500">Evaluation</label>
        <span class="block">{{ $training->evaluation->name }}</span>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Department Assignment</label>
        <div><x-ui.badge :value="$training->assignment" /></div>
      </div>

      @if ($training->assignment === AssignmentType::CLOSED)
        <div class="col-span-full">
          <label class="text-sm font-medium text-base-500">Assigned Departments</label>
          <span class="block mt-1">
            {{ $training->departments->count() == 0 ? 'No departments assigned' : $training->departments->pluck('name')->join(', ') }}
          </span>
        </div>
      @endif
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

      @can('notify', $training)
        <form method="POST" action="{{ route('trainings.notify', $training) }}">
          @csrf
          <x-ui.button>
            <span>Notify</span>
            <i data-lucide="mail" class="size-5"></i>
          </x-ui.button>
        </form>
      @endcan
    </x-slot:footer>
  </x-ui.card>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="user-check" class="size-5 text-primary-500"></i>
      <h4>Assigned Employees</h4>
    </x-slot:title>

    <x-slot:head>
      <th>No</th>
      <th>Name</th>
      <th>Department</th>
      <th>Position</th>
      <th>Score</th>
      <th>Notified</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($assigned as $employee)
        <tr>
          <td class="w-10">{{ $employee->id }}</td>
          <td>
            <div class="flex items-center gap-2">
              <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
              <span>{{ $employee->name }}</span>
            </div>
          </td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->position->name }}</td>
          @can('score', $training)
            <td class="w-36 min-w-28">
              <label for="scores[{{ $employee->id }}]" class="sr-only">Score</label>
              <x-ui.input type="number" class="appearance-none" name="scores[{{ $employee->id }}]"
                id="scores[{{ $employee->id }}]" value="{{ $employee->pivot->score }}">
                <x-slot:right>
                  <span class="text-sm text-base-500">of 100</span>
                </x-slot:right>
              </x-ui.input>
            </td>
          @else
            <td>{{ $employee->pivot->score }} / 100</td>
          @endcan
          <td><x-ui.badge :value="$employee->pivot->email_sent ? BooleanType::YES : BooleanType::NO" /></td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('employees.show', $employee) }}" class="text-primary-500">
                View
              </a>
              @can('unassign', $training)
                <form action="{{ route('trainings.unassign', [$training, $employee]) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-500">
                    Remove
                  </button>
                </form>
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="7" />
      @endforelse
    </x-slot:body>

    @can('score', $training)
      <x-slot:form action="{{ route('trainings.score', $training) }}" method="POST" id="form">
        @csrf
        @method('PATCH')
      </x-slot:form>

      <x-slot:footer class="justify-end">
        <x-ui.button type="submit" form="form">
          <span>Update</span>
          <i data-lucide="arrow-up-right" class="size-5"></i>
        </x-ui.button>
      </x-slot:footer>
    @endcan
  </x-ui.table>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="user-plus" class="size-5 text-primary-500"></i>
      <h4>Available Employees</h4>
    </x-slot:title>

    <x-slot:head>
      <th>No</th>
      <th>Name</th>
      <th>Department</th>
      <th>Position</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($employees as $employee)
        <tr>
          <td class="w-10">{{ $employee->id }}</td>
          <td>
            <div class="flex items-center gap-2">
              <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
              <span>{{ $employee->name }}</span>
            </div>
          </td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->position->name }}</td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('employees.show', $employee) }}" class="text-primary-500">
                View
              </a>
              @can('assign', $training)
                <form action="{{ route('trainings.assign', $training) }}" method="POST">
                  @csrf
                  <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                  <button type="submit" class="text-primary-500">
                    Assign
                  </button>
                </form>
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="7" message="No available employees" />
      @endforelse
    </x-slot:body>
  </x-ui.table>
</x-dashboard-layout>
