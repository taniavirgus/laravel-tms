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

    <div class="grid gap-4 xl:grid-cols-2">
      <dl>
        <dt class="text-sm font-medium text-base-500">Name</dt>
        <dd>{{ $evaluation->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Department</dt>
        <dd>{{ $evaluation->department->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Topic</dt>
        <dd>{{ $evaluation->topic->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Status</dt>
        <dd>
          <x-ui.badge :value="$evaluation->status" />
        </dd>
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
        <dt class="text-sm font-medium text-base-500">Weight</dt>
        <dd class="flex items-center gap-2">
          <i data-lucide="chart-no-axes-column" class="size-4"></i>
          {{ $evaluation->weight }}%
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

  <div class="mt-6">
    <x-ui.table>
      <x-slot:title>
        <i data-lucide="user-check" class="size-5 text-primary-500"></i>
        <h4>Assigned Employees</h4>
      </x-slot:title>

      <x-slot:head>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Position</th>
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
            <td>{{ $employee->email }}</td>
            <td>
              <div class="flex">
                @php
                  $color = $employee->status->color();
                  $class = 'text-white bg-' . $color . '-500';
                @endphp

                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $class }}">
                  {{ $employee->status->label() }}
                </span>
              </div>
            </td>
            <td>{{ $employee->position->name }}</td>
            <td>
              <div class="flex items-center gap-4">
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
    </x-ui.table>
  </div>

  <div class="mt-6">
    <x-ui.table>
      <x-slot:title>
        <i data-lucide="user-plus" class="size-5 text-primary-500"></i>
        <h4>{{ $evaluation->department->name }} Employees</h4>
      </x-slot:title>

      <x-slot:head>
        <th>No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
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
            <td>{{ $employee->email }}</td>
            <td>
              <div class="flex">
                @php
                  $color = $employee->status->color();
                  $class = 'text-white bg-' . $color . '-500';
                @endphp

                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $class }}">
                  {{ $employee->status->label() }}
                </span>
              </div>
            </td>
            <td>{{ $employee->position->name }}</td>
            <td>
              <div class="flex items-center gap-4">
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
  </div>
</x-dashboard-layout>
