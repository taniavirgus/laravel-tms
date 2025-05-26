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

    <x-slot:head>
      <th>No</th>
      <th>Name</th>
      <th>Email</th>
      <th>Department</th>
      <th>Position</th>
      <th>Potential</th>
      <th>Performance</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($employees as $employee)
        <tr>
          <td class="w-10">{{ $loop->iteration }}</td>
          <td>
            <div class="flex items-center gap-2">
              <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
              <span>{{ $employee->name }}</span>
            </div>
          </td>
          <td>{{ $employee->email }}</td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->position->name }}</td>
          <td class="font-semibold">{{ round($employee->potential) }}</td>
          <td class="font-semibold">{{ round($employee->performance) }}</td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('employees.show', $employee) }}" class="text-primary-500">
                View
              </a>
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="8" />
      @endforelse
    </x-slot:body>
    
    <x-slot:footer class="justify-end">
      <a href="{{ route('talents.index') }}">
        <x-ui.button variant="outline">
          <span>Back</span>
        </x-ui.button>
      </a>
    </x-slot:footer>
  </x-ui.table>
</x-dashboard-layout> 