<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Users List</x-slot:title>
    <x-slot:description>Manage system users in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="users" class="size-5 text-primary-500"></i>
      <h4>Users Table</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('users.index') }}" method="GET" class="flex flex-col gap-2 sm:flex-row sm:items-center">
        <x-ui.input name="search" value="{{ request('search') }}" placeholder="Search by name or email">
          <x-slot:left>
            <i data-lucide="search" class="text-base-500 size-5"></i>
          </x-slot:left>
        </x-ui.input>

        <x-ui.select name="role" onchange="this.form.submit()">
          <option value="">All Roles</option>
          @foreach ($roles as $role)
            <option value="{{ $role->value }}" @selected(request('role') == $role->value)>{{ $role->label() }}</option>
          @endforeach
        </x-ui.select>
      </form>

      <div class="flex items-center gap-2">
        @if (request()->has('search'))
          <a href="{{ route('users.index') }}">
            <x-ui.button variant="outline">
              <i data-lucide="x" class="size-5"></i>
              <span>Reset</span>
            </x-ui.button>
          </a>
        @endif

        <a href="{{ route('users.create') }}">
          <x-ui.button>
            <i data-lucide="plus" class="size-5"></i>
            <span>User</span>
          </x-ui.button>
        </a>
      </div>
    </x-slot:action>

    <x-slot:head>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($users as $user)
        <tr>
          <td class="w-10">{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            <x-ui.badge :value="$user->role" />
          </td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('users.edit', $user) }}" class="text-primary-500">
                Edit
              </a>

              @can('delete', $user)
                <x-delete id="{{ $user->id }}" title="{{ $user->name }}"
                  route="{{ route('users.destroy', $user) }}" />
              @endcan
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="5" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $users->links() }}
</x-dashboard-layout>
