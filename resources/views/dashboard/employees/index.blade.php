<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Employees List</x-slot:title>
    <x-slot:description>Manage list of employees in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="users" class="size-5 text-primary-500"></i>
      <h4>Employees Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form x-data="{}" action="{{ route('employees.index') }}" method="GET"
        class="flex flex-col gap-2 xl:flex-row xl:items-center">
        <x-ui.input name="search" value="{{ request('search') }}" placeholder="Search by name or email">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>

        <x-ui.select name="department_id" placeholder="Department" x-on:change="$el.form.submit()">
          <option value="">Select Department</option>
          @foreach ($departments as $department)
            <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>
              {{ $department->name }}
            </option>
          @endforeach
        </x-ui.select>

        <x-ui.select name="position_id" placeholder="Position" x-on:change="$el.form.submit()">
          <option value="">Select Position</option>
          @foreach ($positions as $position)
            <option value="{{ $position->id }}" @selected(request('position_id') == $position->id)>
              {{ $position->name }}
            </option>
          @endforeach
        </x-ui.select>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('employees.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        <a href="{{ route('employees.create') }}">
          <x-ui.button>
            <i data-lucide="plus" class="size-5"></i>
            <span>Employee</span>
          </x-ui.button>
        </a>
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>No</th>
      <th>Name</th>
      <th>Email</th>
      <th>Department</th>
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
          <td>{{ $employee->department->name }}</td>
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
              <a href="{{ route('employees.edit', $employee) }}" class="text-primary-500">
                Edit
              </a>
              <x-delete id="{{ $employee->id }}" title="{{ $employee->name }}"
                route="{{ route('employees.destroy', $employee) }}" />
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="8" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $employees->links() }}
</x-dashboard-layout>
