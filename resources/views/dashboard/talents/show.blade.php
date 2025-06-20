@php
  use App\Enums\BooleanType;
  use App\Enums\AssignmentType;
@endphp

<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>{{ $talent->name }} training</x-slot:title>
    <x-slot:description>{{ $talent->description }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card>
    <x-slot:header>
      <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
      <h5>Talent Training Details</h5>
    </x-slot:header>

    <div class="xl:grid-cols-4 form">
      <div class="col-span-2">
        <label class="text-sm font-medium text-base-500">Start date</label>
        <div class="text-4xl font-bold">
          {{ $talent->start_date->format('F jS, Y') }}
        </div>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Status</label>
        <div><x-ui.badge :value="$talent->status" /></div>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Duration</label>
        <span class="block">{{ $talent->duration }} Hours</span>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Date End</label>
        <span class="block">{{ $talent->end_date->format('F jS, Y') }}</span>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Participants</label>
        <span class="block">{{ $assigned->count() }} Employees</span>
      </div>

      <div>
        <label class="text-sm font-medium text-base-500">Talent Segment</label>
        <div><x-ui.badge :value="$talent->segment" /></div>
      </div>
    </div>

    <x-slot:footer class="justify-end">
      <a href="{{ route('talents.index') }}">
        <x-ui.button variant="outline" type="button">
          <span>Back</span>
        </x-ui.button>
      </a>

      @can('update', $talent)
        <a href="{{ route('talents.edit', $talent) }}">
          <x-ui.button>
            <span>Edit</span>
            <i data-lucide="arrow-up-right" class="size-5"></i>
          </x-ui.button>
        </a>
      @endcan

      @can('notify', $talent)
        <form method="POST" action="{{ route('talents.notify', $talent) }}">
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
          <td class="w-10">{{ $loop->iteration }}</td>
          <td>
            <div class="flex items-center gap-2">
              <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
              <span>{{ $employee->name }}</span>
            </div>
          </td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->position->name }}</td>
          <td>{{ $employee->pivot->score }} / 100</td>
          <td><x-ui.badge :value="$employee->pivot->email_sent ? BooleanType::YES : BooleanType::NO" /></td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('employees.show', $employee) }}" class="text-primary-500">
                View
              </a>

              @can('unassign', $talent)
                <form action="{{ route('talents.unassign', [$talent, $employee]) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-500">
                    Remove
                  </button>
                </form>
              @endcan

              @can('score', $talent)
                <x-talent-score id="{{ $employee->id }}" title="{{ $employee->name }}"
                  route="{{ route('talents.score', [$talent, $employee]) }}" score="{{ $employee->pivot->score }}"
                  notes="{{ $employee->pivot->notes }}" />
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="7" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  <x-ui.table>
    <x-slot:action class="justify-between">
      <form action="{{ route('talents.show', $talent) }}" method="GET"
        class="flex flex-col gap-2 xl:flex-row xl:items-center">
        <x-ui.input name="search" value="{{ request()->get('search') }}" placeholder="Search by name or email">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>

        <x-ui.select name="department_id" onchange="this.form.submit()">
          <option value="">All Departments</option>
          @foreach ($departments as $department)
            <option value="{{ $department->id }}" @selected(request()->get('department_id') == $department->id)>{{ $department->name }}</option>
          @endforeach
        </x-ui.select>

        <x-ui.select name="position_id" placeholder="Position" onchange="this.form.submit()">
          <option value="">Select Position</option>
          @foreach ($positions as $position)
            <option value="{{ $position->id }}" @selected(request()->get('position_id') == $position->id)>{{ $position->name }}</option>
          @endforeach
        </x-ui.select>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('talents.show', $talent) }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif
      </div>
    </x-slot:action>

    <x-slot:title>
      <i data-lucide="user-plus" class="size-5 text-primary-500"></i>
      <h4>Available Employees</h4>
    </x-slot:title>

    <x-slot:head>
      <th>No</th>
      <th>Name</th>
      <th>Segment</th>
      <th>Department</th>
      <th>Position</th>
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
          <td><x-ui.badge :value="$talent->segment" /></td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->position->name }}</td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('employees.show', $employee) }}" class="text-primary-500">
                View
              </a>
              @can('assign', $talent)
                <form action="{{ route('talents.assign', $talent) }}" method="POST">
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

  {{ $employees->links() }}
</x-dashboard-layout>
