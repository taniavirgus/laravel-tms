<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Topics List</x-slot:title>
    <x-slot:description>Manage list of topics in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="book-open" class="size-5 text-primary-500"></i>
      <h4>Topics Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('topics.index') }}" method="GET" class="flex flex-col gap-2 xl:flex-row xl:items-center">
        <x-ui.input name="search" value="{{ request()->get('search') }}" placeholder="Search by name or description">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('topics.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        @can('create', App\Models\Topic::class)
          <a href="{{ route('topics.create') }}">
            <x-ui.button>
              <i data-lucide="plus" class="size-5"></i>
              <span>Topic</span>
            </x-ui.button>
          </a>
        @endcan
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>No</th>
      <th>Topic Name</th>
      <th>Description</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($topics as $topic)
        <tr>
          <td class="w-10">{{ $topic->id }}</td>
          <td>{{ $topic->name }}</td>
          <td>
            <p class="truncate">{{ $topic->description }}</p>
          </td>
          <td>
            <div class="flex items-center gap-4">
              @can('update', $topic)
                <a href="{{ route('topics.edit', $topic) }}" class="text-primary-500">
                  Edit
                </a>
              @endcan

              @can('delete', $topic)
                <x-delete id="{{ $topic->id }}" title="{{ $topic->name }}"
                  route="{{ route('topics.destroy', $topic) }}" />
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="4" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $topics->links() }}
</x-dashboard-layout>
