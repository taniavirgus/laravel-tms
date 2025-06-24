<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Talent Trainings List</x-slot:title>
    <x-slot:description>Manage list of talent trainings in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="graduation-cap" class="size-5 text-primary-500"></i>
      <h4>Talent Trainings Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('talents.index') }}" method="GET" class="flex flex-col gap-2 xl:flex-row xl:items-center">
        <x-ui.input name="search" value="{{ request()->get('search') }}" placeholder="Search by name or description">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>

        <x-ui.select name="status" onchange="this.form.submit()">
          <option value="">All Statuses</option>
          @foreach ($statuses as $status)
            <option value="{{ $status->value }}" @selected(request()->get('status') == $status->value)>{{ $status->label() }}</option>
          @endforeach
        </x-ui.select>

        <x-ui.select name="segment" onchange="this.form.submit()">
          <option value="">All Segments</option>
          @foreach ($segments as $segment)
            <option value="{{ $segment->value }}" @selected(request()->get('segment') == $segment->value)>{{ $segment->label() }}</option>
          @endforeach
        </x-ui.select>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('talents.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        @can('create', App\Models\TalentTraining::class)
          <a href="{{ route('talents.create') }}">
            <x-ui.button>
              <i data-lucide="plus" class="size-5"></i>
              <span>Training</span>
            </x-ui.button>
          </a>
        @endcan

        @can('export', App\Models\TalentTraining::class)
          <a href="{{ route('talents.export') }}">
            <x-ui.button size="icon" variant="outline" tooltip="Export talent trainings">
              <i data-lucide="download" class="size-5"></i>
            </x-ui.button>
          </a>
        @endcan
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>No</th>
      <th>Title</th>
      <th>Date</th>
      <th>Segement</th>
      <th>Status</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($talents as $talent)
        <tr>
          <td class="w-10">{{ $talents->firstItem() + $loop->index }}</td>
          <td>{{ $talent->name }}</td>
          <td>
            <div class="flex items-center gap-2">
              <span class="whitespace-nowrap">{{ $talent->start_date->format('d M Y') }}</span>
              <hr class="w-10 bg-base-500" />
              <span class="whitespace-nowrap">{{ $talent->end_date->format('d M Y') }}</span>
            </div>
          </td>
          <td><x-ui.badge :value="$talent->segment" /></td>
          <td><x-ui.badge :value="$talent->status" /></td>
          <td>
            <div class="flex items-center gap-4">
              @can('view', $talent)
                <a href="{{ route('talents.show', $talent) }}" class="text-primary-500">
                  View
                </a>
              @endcan

              @can('update', $talent)
                <a href="{{ route('talents.edit', $talent) }}" class="text-primary-500">
                  Edit
                </a>
              @endcan

              @can('delete', $talent)
                <x-delete id="{{ $talent->id }}" title="{{ $talent->name }}"
                  route="{{ route('talents.destroy', $talent) }}" />
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="7" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $talents->links() }}
</x-dashboard-layout>
