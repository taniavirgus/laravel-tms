<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>{{ $training->name }} training</x-slot:title>
    <x-slot:description>{{ $training->description }}</x-slot:description>
  </x-dashboard.heading>

  <div class="grid items-start gap-10 xl:grid-cols-2">
    <x-ui.card>
      <x-slot:header>
        <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
        <h5>Training Details</h5>
      </x-slot:header>

      <div class="form">
        <div class="flex flex-col items-start gap-2">
          <x-ui.badge :value="$training->status" />
          <div class="text-5xl font-bold">{{ $training->start_date->format('l  jS') }}</div>
          <span>{{ $training->start_date->format('F Y') }}</span>
        </div>

        <div class="grid-cols-2 form">
          <div>
            <label class="text-sm font-medium text-base-500">Duration</label>
            <span class="block">{{ $training->duration }} Hours</span>
          </div>

          <div>
            <label class="text-sm font-medium text-base-500">Date End</label>
            <span class="block">{{ $training->end_date->format('F jS, Y') }}</span>
          </div>
        </div>
      </div>
    </x-ui.card>

    <x-ui.card>
      <x-slot:header>
        <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
        <h5>Training Details</h5>
      </x-slot:header>

      <div class="grid-cols-2 form">
        <div>
          <label class="text-sm font-medium text-base-500">Department</label>
          <span class="block">{{ $training->department->name }}</span>
        </div>

        <div>
          <label class="text-sm font-medium text-base-500">Notified</label>
          <span class="block">{{ $training->notified ? 'Yes' : 'No' }}</span>
        </div>

        <div class="col-span-full">
          <label class="text-sm font-medium text-base-500">Evaluation</label>
          <span class="block">{{ $training->evaluation->name }}</span>
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
      </div>

      @can('update', $training)
        <x-slot:footer class="justify-end">
          <a href="{{ route('trainings.edit', $training) }}">
            <x-ui.button>
              <span>Edit</span>
              <i data-lucide="arrow-up-right" class="size-5"></i>
            </x-ui.button>
          </a>

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
      @endcan
    </x-ui.card>
  </div>



  @can('score', $training)
    <form action="{{ route('trainings.score', $training) }}" method="POST" id="form">
      @csrf
      @method('PATCH')
    @endcan

    <x-ui.table>
      <x-slot:title>
        <i data-lucide="user-check" class="size-5 text-primary-500"></i>
        <h4>Assigned Employees</h4>
      </x-slot:title>

      <x-slot:head>
        <th>No</th>
        <th>Name</th>
        <th>Score</th>
        <th>Actions</th>
      </x-slot:head>

      <x-slot:body>
        @forelse ($assigned as $employee)
          <tr>
            <td class="w-10">{{ $employee->id }}</td>
            <td>
              <a href="{{ route('employees.show', $employee) }}" class="flex items-center gap-2">
                <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
                <span>{{ $employee->name }}</span>
              </a>
            </td>
            @can('score', $training)
              <td>
                <div class="w-40">
                  <x-ui.range name="scores[{{ $employee->id }}]" id="scores[{{ $employee->id }}]" step="1"
                    value="{{ $employee->pivot->score }}" :tooltip="false" />
                </div>
              </td>
            @else
              <td>{{ $employee->pivot->score }}</td>
            @endcan
            <td>
              <div class="flex items-center gap-4">
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
        <x-slot:footer class="justify-end">
          <x-ui.button type="submit">
            <span>Update</span>
            <i data-lucide="arrow-up-right" class="size-5"></i>
          </x-ui.button>
        </x-slot:footer>
      @endcan
    </x-ui.table>

    @can('score', $training)
    </form>
  @endcan

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="user-plus" class="size-5 text-primary-500"></i>
      <h4>{{ $training->department->name }} Employees</h4>
    </x-slot:title>

    <x-slot:head>
      <th>No</th>
      <th>Name</th>
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
          <td>
            <div class="flex items-center gap-4">
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
        <x-ui.empty colspan="7" message="No available employees in this department" />
      @endforelse
    </x-slot:body>
  </x-ui.table>
</x-dashboard-layout>
