<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Positions List</x-slot:title>
    <x-slot:description>Manage list of positions in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="briefcase" class="size-5 text-primary-500"></i>
      <h4>Positions Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('sysadmin.positions.index') }}" method="GET" class="w-full max-w-sm">
        <x-ui.input name="search" value="{{ request('search') }}" placeholder="Search by name or description">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('sysadmin.positions.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        <a href="{{ route('sysadmin.positions.create') }}">
          <x-ui.button>
            <i data-lucide="plus" class="size-5"></i>
            <span>Position</span>
          </x-ui.button>
        </a>
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>No</th>
      <th>Position Name</th>
      <th>Level</th>
      <th>Description</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($positions as $position)
        <tr>
          <td class="w-10">{{ $position->id }}</td>
          <td>{{ $position->name }}</td>
          <td>
            <div class="flex">
              @php
                $color = $position->level->color();
                $class = 'border border-' . $color . '-500';
              @endphp

              <span class="flex gap-2 px-3 py-1 text-xs font-medium rounded-full {{ $class }}">
                {{ $position->level->label() }}
              </span>
            </div>
          </td>
          <td>
            <p class="truncate">
              {{ $position->description }}
            </p>
          </td>
          <td>
            <a href="{{ route('sysadmin.positions.edit', $position) }}" class="text-primary-500">
              Edit
            </a>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="5" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $positions->links() }}
</x-dashboard-layout>
