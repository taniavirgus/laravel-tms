@props([
        //
    ])

@php
  $props = $attributes
      ->class([
          'border-r border-base-200',
          'fixed top-0 left-0 z-40 h-screen',
          'transition-transform -translate-x-full bg-white md:translate-x-0',
      ])
      ->merge([
          'id' => 'sidebar',
          'class' => 'w-full',
          'aria-label' => 'Sidenav',
      ]);

  $navigations = array_to_object([
      [
          'id' => 'users',
          'label' => 'Users',
          'menus' => [
              [
                  'href' => route('users.index'),
                  'active' => request()->routeIs('users.index'),
                  'name' => 'User List',
                  'icon' => 'users',
              ],
              [
                  'href' => route('users.create'),
                  'active' => request()->routeIs('users.create'),
                  'name' => 'Add User',
                  'icon' => 'plus',
              ],
          ],
      ],
      [
          'id' => 'departments',
          'label' => 'Departments',
          'menus' => [
              [
                  'href' => route('departments.index'),
                  'active' => request()->routeIs('departments.index'),
                  'name' => 'Department List',
                  'icon' => 'house',
              ],
              [
                  'href' => route('departments.create'),
                  'active' => request()->routeIs('departments.create'),
                  'name' => 'Add Department',
                  'icon' => 'plus',
              ],
          ],
      ],
      [
          'id' => 'positions',
          'label' => 'Positions',
          'menus' => [
              [
                  'href' => route('positions.index'),
                  'active' => request()->routeIs('positions.index'),
                  'name' => 'Position List',
                  'icon' => 'briefcase',
              ],
              [
                  'href' => route('positions.create'),
                  'active' => request()->routeIs('positions.create'),
                  'name' => 'Add Position',
                  'icon' => 'plus',
              ],
          ],
      ],
      [
          'id' => 'employees',
          'label' => 'Employee',
          'menus' => [
              [
                  'href' => route('employees.index'),
                  'active' => request()->routeIs('employees.index'),
                  'name' => 'Employee List',
                  'icon' => 'users',
              ],
              [
                  'href' => route('employees.create'),
                  'active' => request()->routeIs('employees.create'),
                  'name' => 'Add Employee',
                  'icon' => 'plus',
                  'show' => Auth::user()->can('create', App\Models\Employee::class),
              ],
          ],
      ],
      [
          'id' => 'evaluations',
          'label' => 'Evaluation',
          'menus' => [
              [
                  'href' => route('topics.index'),
                  'active' => request()->routeIs('topics.*'),
                  'name' => 'Evaluation Topic',
                  'icon' => 'clipboard-list',
              ],
              [
                  'href' => route('evaluations.index'),
                  'active' => request()->routeIs('evaluations.index'),
                  'name' => 'Evaluation List',
                  'icon' => 'chart-pie',
              ],
              [
                  'href' => route('evaluations.summary'),
                  'active' => request()->routeIs('evaluations.summary'),
                  'name' => 'Performance Summary',
                  'icon' => 'chart-bar',
              ],
          ],
      ],
      [
          'id' => 'trainings',
          'label' => 'Training',
          'menus' => [
              [
                  'href' => route('trainings.index'),
                  'active' => request()->routeIs('trainings.index'),
                  'name' => 'Training List',
                  'icon' => 'graduation-cap',
              ],
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'Assign Employee',
                  'icon' => 'user-plus',
                  'count' => 3,
              ],
          ],
      ],
      [
          'id' => 'developments',
          'label' => 'Talent Pool',
          'menus' => [
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'Talent Pool List',
                  'icon' => 'building2',
              ],
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'Assign Employee',
                  'icon' => 'user-plus',
                  'count' => 3,
              ],
          ],
      ],
      [
          'id' => 'account',
          'label' => 'Account',
          'menus' => [
              [
                  'href' => route('profile.edit'),
                  'active' => request()->routeIs('profile.edit'),
                  'name' => 'Profile',
                  'icon' => 'user2',
              ],
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'Settings',
                  'icon' => 'settings',
              ],
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'Help',
                  'icon' => 'help-circle',
              ],
          ],
      ],
  ]);
@endphp

<aside {{ $props }}>
  <div class="flex flex-col h-full gap-6 overflow-y-auto">
    <div class="sticky top-0 z-10 bg-white border-b border-base-200">
      <a href="{{ route('dashboard') }}" class="flex items-center h-20 px-6">
        <x-ui.logo class="max-w-32" />
      </a>
    </div>

    @foreach ($navigations as $navigation)
      @continue(Auth::user()->permitted($navigation->id) === false)

      <div class="grid gap-2">
        <h3 class="px-6 text-sm font-medium text-base-400">{{ $navigation->label }}</h3>
        <ul>
          @foreach ($navigation->menus as $menu)
            <li class="relative text-sm font-medium">
              @if ($menu->active)
                <div class="absolute top-0 right-0 w-1 h-full bg-primary-500"></div>
              @endif

              @isset($menu->show)
                @continue(!$menu->show)
              @endisset

              @isset($menu->count)
                <div class="absolute text-center transform -translate-y-1/2 right-6 top-1/2">
                  <div class="rounded-md text-primary-500 size-5 bg-primary-100">{{ $menu->count }}</div>
                </div>
              @endisset

              <a href="{{ $menu->href }}"
                class="flex items-center gap-3 p-3 px-6 rounded-lg hover:bg-primary-50 @if ($menu->active) bg-primary-50 @endif">
                <i data-lucide="{{ $menu->icon }}" class="size-5 text-primary-500"></i>
                <span>{{ $menu->name }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    @endforeach
  </div>

  <div class="absolute bottom-0 left-0 z-20 w-full bg-white border-t border-base-200">
    <div class="items-center hidden h-16 gap-2 px-6 item-center lg:flex">
      <a href="#">
        <x-ui.button size="icon" variant="ghost" tooltip="Settings page" class="rounded-full size-8">
          <i data-lucide="settings" class="size-5"></i>
        </x-ui.button>
      </a>

      <a href="#">
        <x-ui.button size="icon" variant="ghost" tooltip="Help page" class="rounded-full size-8">
          <i data-lucide="help-circle" class="size-5"></i>
        </x-ui.button>
      </a>
    </div>
  </div>
</aside>
