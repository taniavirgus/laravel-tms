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
          <td class="w-10">{{ $loop->iteration }}</td>
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
      <a href="{{ route('talents.index') }}">
        <x-ui.button variant="outline">
          <span>Back</span>
        </x-ui.button>
      </a>
    </x-slot:footer>
  </x-ui.table>
</x-dashboard-layout>
