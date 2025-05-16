<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Trainings List</x-slot:title>
    <x-slot:description>Manage list of trainings in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="graduation-cap" class="size-5 text-primary-500"></i>
      <h4>Trainings Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('trainings.index') }}" method="GET" class="flex flex-col gap-2 xl:flex-row xl:items-center">
        <x-ui.input name="search" value="{{ request()->get('search') }}" placeholder="Search by name or description">
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

        <x-ui.select name="status" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          <option value="upcoming" @selected(request()->get('status') == 'upcoming')>Upcoming</option>
          <option value="completed" @selected(request()->get('status') == 'completed')>Completed</option>
        </x-ui.select>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('trainings.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        @can('create', App\Models\Training::class)
          <a href="{{ route('trainings.create') }}">
            <x-ui.button>
              <i data-lucide="plus" class="size-5"></i>
              <span>Training</span>
            </x-ui.button>
          </a>
        @endcan
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>No</th>
      <th>Training Name</th>
      <th>Department</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Status</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($trainings as $training)
        <tr>
          <td class="w-10">{{ $training->id }}</td>
          <td>{{ $training->name }}</td>
          <td>{{ $training->department->name }}</td>
          <td>{{ $training->start_date->format('d M Y') }}</td>
          <td>{{ $training->end_date->format('d M Y') }}</td>
          <td><x-ui.badge :value="$training->status" /></td>
          <td>
            <div class="flex items-center gap-4">
              @can('view', $training)
                <a href="{{ route('trainings.show', $training) }}" class="text-primary-500">
                  View
                </a>
              @endcan

              @can('update', $training)
                <a href="{{ route('trainings.edit', $training) }}" class="text-primary-500">
                  Edit
                </a>
              @endcan

              @can('delete', $training)
                <x-delete id="{{ $training->id }}" title="{{ $training->name }}"
                  route="{{ route('trainings.destroy', $training) }}" />
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="7" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $trainings->links() }}
</x-dashboard-layout>
