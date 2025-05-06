<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Departments List</x-slot:title>
    <x-slot:description>Manage list of departments in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="building2" class="size-5 text-primary-500"></i>
      <h4>Departments Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('sysadmin.departments.index') }}" method="GET" class="w-full max-w-sm">
        <x-ui.input name="search" value="{{ request('search') }}" placeholder="Search by name or description">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('sysadmin.departments.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        <a href="{{ route('sysadmin.departments.create') }}">
          <x-ui.button>
            <i data-lucide="plus" class="size-5"></i>
            <span>Department</span>
          </x-ui.button>
        </a>
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>No</th>
      <th>Department Name</th>
      <th>Description</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @foreach ($departments as $department)
        <tr>
          <td class="w-10">{{ $department->id }}</td>
          <td>{{ $department->name }}</td>
          <td>
            <p class="truncate">
              {{ $department->description }}
            </p>
          </td>
          <td>
            <a href="{{ route('sysadmin.departments.edit', $department) }}" class="text-primary-500">
              Edit
            </a>
          </td>
        </tr>
      @endforeach
    </x-slot:body>
  </x-ui.table>

  {{ $departments->links() }}
</x-dashboard-layout>
