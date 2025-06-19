<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Periods List</x-slot:title>
    <x-slot:description>Manage list of periods in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="calendar" class="size-5 text-primary-500"></i>
      <h4>Periods Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('periods.index') }}" method="GET" class="w-full max-w-sm">
        <x-ui.input name="search" value="{{ request()->get('search') }}" placeholder="Search by year or semester">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('periods.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        <a href="{{ route('periods.create') }}">
          <x-ui.button>
            <i data-lucide="plus" class="size-5"></i>
            <span>Period</span>
          </x-ui.button>
        </a>
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>No</th>
      <th>Period Name</th>
      <th>Evaluations</th>
      <th>Trainings</th>
      <th>Behavior</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($periods as $period)
        <tr>
          <td class="w-10">{{ $periods->firstItem() + $loop->index }}</td>
          <td>{{ $period->name }}</td>
          <td>{{ $period->evaluations_count }}</td>
          <td>{{ $period->trainings_count }}</td>
          <td>{{ $period->feedback_count }}</td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('periods.edit', $period) }}" class="text-primary-500">
                Edit
              </a>
              <x-delete id="{{ $period->id }}" title="{{ $period->name }}"
                route="{{ route('periods.destroy', $period) }}" />
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="6" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $periods->links() }}
</x-dashboard-layout>
