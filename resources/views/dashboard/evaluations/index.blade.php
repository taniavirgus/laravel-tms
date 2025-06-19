<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Evaluations List</x-slot:title>
    <x-slot:description>Manage evaluations in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
      <h4>Evaluations Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('evaluations.index') }}" method="GET"
        class="flex flex-col gap-2 xl:flex-row xl:items-center">
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

        <x-ui.select name="topic_id" onchange="this.form.submit()">
          <option value="">All Topics</option>
          @foreach ($topics as $topic)
            <option value="{{ $topic->id }}" @selected(request()->get('topic_id') == $topic->id)>{{ $topic->name }}</option>
          @endforeach
        </x-ui.select>

        <x-ui.select name="status" placeholder="Status" onchange="this.form.submit()">
          <option value="">Select Status</option>
          @foreach ($statuses as $status)
            <option value="{{ $status->value }}" @selected(request()->get('status') == $status->value)>{{ $status->label() }}</option>
          @endforeach
        </x-ui.select>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->hasAny(['search', 'department_id', 'topic_id']))
          <a href="{{ route('evaluations.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        @can('create', App\Models\Evaluation::class)
          <a href="{{ route('evaluations.create') }}">
            <x-ui.button>
              <i data-lucide="plus" class="size-5"></i>
              <span>Evaluation</span>
            </x-ui.button>
          </a>
        @endcan
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>No</th>
      <th>Name</th>
      <th>Department</th>
      <th>Position</th>
      <th>Topic</th>
      <th>Status</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($evaluations as $evaluation)
        <tr>
          <td class="w-10">{{ $evaluations->firstItem() + $loop->index }}</td>
          <td>{{ $evaluation->name }}</td>
          <td>{{ $evaluation->department->name }}</td>
          <td>{{ $evaluation->position->name }}</td>
          <td>{{ $evaluation->topic->name }}</td>
          <td><x-ui.badge :value="$evaluation->status" /></td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('evaluations.show', $evaluation) }}" class="text-primary-500">
                View
              </a>

              @can('update', $evaluation)
                <a href="{{ route('evaluations.edit', $evaluation) }}" class="text-primary-500">
                  Edit
                </a>
              @endcan

              @can('approval', $evaluation)
                <x-approval id="{{ $evaluation->id }}" title="{{ $evaluation->name }}"
                  route="{{ route('evaluations.approval', $evaluation) }}" />
              @endcan

              @can('delete', $evaluation)
                <x-delete id="{{ $evaluation->id }}" title="{{ $evaluation->name }}"
                  route="{{ route('evaluations.destroy', $evaluation) }}" />
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="9" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $evaluations->links() }}
</x-dashboard-layout>
