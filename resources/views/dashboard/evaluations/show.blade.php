<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Evaluation Details</x-slot:title>
    <x-slot:description>View evaluation information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card>
    <x-slot:header>
      <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
      <h5>Evaluation Details</h5>
    </x-slot:header>

    <div class="form xl:grid-cols-2">
      <dl>
        <dt class="text-sm font-medium text-base-500">Name</dt>
        <dd>{{ $evaluation->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Department</dt>
        <dd>{{ $evaluation->department->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Position</dt>
        <dd>{{ $evaluation->position->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Topic</dt>
        <dd>{{ $evaluation->topic->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Status</dt>
        <dd><x-ui.badge :value="$evaluation->status" /></dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Point</dt>
        <dd class="flex items-center gap-2">
          <i data-lucide="chart-no-axes-column" class="size-4"></i>
          {{ $evaluation->point }}
        </dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Target</dt>
        <dd class="flex items-center gap-2">
          <i data-lucide="chart-no-axes-column" class="size-4"></i>
          {{ $evaluation->target }}
        </dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Unit</dt>
        <dd class="flex items-center gap-2">
          <i data-lucide="chart-no-axes-column" class="size-4"></i>
          {{ $evaluation->unit }}
        </dd>
      </dl>

      <dl class="col-span-full">
        <dt class="text-sm font-medium text-base-500">Description</dt>
        <dd>
          <p>{{ $evaluation->description }}</p>
        </dd>
      </dl>
    </div>

    <x-slot:footer class="justify-end">
      <a href="{{ route('evaluations.index') }}">
        <x-ui.button variant="outline" type="button">
          <span>Back</span>
        </x-ui.button>
      </a>

      @can('approval', $evaluation)
        <x-approval id="{{ $evaluation->id }}" title="{{ $evaluation->name }}"
          route="{{ route('evaluations.approval', $evaluation) }}"
          class="p-3 px-6 text-sm font-medium text-white border border-transparent rounded-lg focus:outline-none bg-primary-500 both:bg-primary-600" />
      @endcan

      @can('update', $evaluation)
        <a href="{{ route('evaluations.edit', $evaluation) }}">
          <x-ui.button>
            <span>Edit</span>
            <i data-lucide="arrow-up-right" class="size-5"></i>
          </x-ui.button>
        </a>
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
      <th>Status</th>
      <th>Department</th>
      <th>Position</th>
      <th>Score</th>
      <th>Unit</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($assigned as $employee)
        <tr>
          <td class="w-10">{{ $loop->iteration }}</td>
          <td>
            <a href="{{ route('employees.show', $employee) }}" class="flex items-center gap-2">
              <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
              <span>{{ $employee->name }}</span>
            </a>
          </td>
          <td><x-ui.badge :value="$employee->status" /></td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->position->name }}</td>
          @can('score', $evaluation)
            <td class="w-36 min-w-28">
              <label for="scores[{{ $employee->id }}]" class="sr-only">Score</label>
              <x-ui.input type="number" class="appearance-none" name="scores[{{ $employee->id }}]"
                id="scores[{{ $employee->id }}]" max="{{ $evaluation->target }}" value="{{ $employee->pivot->score }}">
                <x-slot:right>
                  <span class="text-sm text-base-500">of {{ $evaluation->target }}</span>
                </x-slot:right>
              </x-ui.input>
            </td>
          @else
            <td>{{ $employee->pivot->score }} / {{ $evaluation->target }}</td>
          @endcan
          <td>{{ $evaluation->unit }}</td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('employees.show', $employee) }}" class="text-primary-500">
                View
              </a>
              @can('unassign', $evaluation)
                <form action="{{ route('evaluations.unassign', [$evaluation, $employee]) }}" method="POST">
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

    @can('score', $evaluation)
      <x-slot:form action="{{ route('evaluations.score', $evaluation) }}" method="POST" id="form">
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
    <x-slot:action class="justify-between">
      <form action="{{ route('evaluations.show', $evaluation) }}" method="GET"
        class="flex flex-col gap-2 xl:flex-row xl:items-center">
        <x-ui.input name="search" value="{{ request()->get('search') }}" placeholder="Search by name or email">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('evaluations.show', $evaluation) }}">
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
      <th>Status</th>
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
          <td><x-ui.badge :value="$employee->status" /></td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->position->name }}</td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('employees.show', $employee) }}" class="text-primary-500">
                View
              </a>
              @can('assign', $evaluation)
                <form action="{{ route('evaluations.assign', $evaluation) }}" method="POST">
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

  {{ $employees->links() }}
</x-dashboard-layout>
