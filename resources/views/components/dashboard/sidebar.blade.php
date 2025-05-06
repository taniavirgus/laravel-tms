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
          'id' => 'departments',
          'label' => 'Departments',
          'menus' => [
              [
                  'href' => route('sysadmin.departments.index'),
                  'active' => request()->routeIs('sysadmin.departments.index'),
                  'name' => 'Department List',
                  'icon' => 'house',
              ],
              [
                  'href' => route('sysadmin.departments.create'),
                  'active' => request()->routeIs('sysadmin.departments.create'),
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
                  'href' => route('sysadmin.positions.index'),
                  'active' => request()->routeIs('sysadmin.positions.index'),
                  'name' => 'Position List',
                  'icon' => 'briefcase',
              ],
              [
                  'href' => route('sysadmin.positions.create'),
                  'active' => request()->routeIs('sysadmin.positions.create'),
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
                  'href' => route('sysadmin.employees.index'),
                  'active' => request()->routeIs('sysadmin.employees.index'),
                  'name' => 'Employee List',
                  'icon' => 'users',
              ],
              [
                  'href' => route('sysadmin.employees.create'),
                  'active' => request()->routeIs('sysadmin.employees.create'),
                  'name' => 'Add Employee',
                  'icon' => 'user-plus',
              ],
          ],
      ],
      [
          'id' => 'evaluations',
          'label' => 'Evaluation',
          'menus' => [
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'KPI List',
                  'icon' => 'chart-pie',
              ],
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'Assign Employee KPI',
                  'icon' => 'user-plus',
              ],
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'Performance Summary',
                  'icon' => 'chart-bar',
              ],
              [
                  'href' => '#',
                  'active' => false,
                  'name' => 'Performance History',
                  'icon' => 'calendar',
              ],
          ],
      ],
      [
          'id' => 'trainings',
          'label' => 'Training',
          'menus' => [
              [
                  'href' => '#',
                  'active' => false,
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

          @if ($loop->last)
            <li class="relative text-sm font-medium">
              <a href="#"
                class="flex items-center gap-3 p-3 px-6 rounded-lg hover:bg-primary-50 @if ($menu->active) bg-primary-50 @endif">
                <i data-lucide="chevron-down" class="size-5 text-primary-500"></i>
                <span>See All</span>
              </a>
            </li>
          @endif
        </ul>
      </div>
    @endforeach
  </div>

  <div class="absolute bottom-0 left-0 z-20 w-full bg-white border-t border-base-200">
    <div class="items-center hidden h-16 gap-4 px-6 item-center lg:flex">
      <a href="#" data-tooltip-target="settings">
        <i data-lucide="settings" class="size-5"></i>
      </a>

      <a href="#" data-tooltip-target="help">
        <i data-lucide="help-circle" class="size-5"></i>
      </a>

      <div id="settings" role="tooltip" class="absolute z-10 invisible opacity-0 tooltip">
        <div class="px-3 py-2 text-sm font-medium text-white rounded-lg whitespace-nowrap bg-base-900">
          <span>Settings page</span>
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>

      <div id="help" role="tooltip" class="absolute z-10 invisible opacity-0 tooltip">
        <div class="px-3 py-2 text-sm font-medium text-white rounded-lg whitespace-nowrap bg-base-900">
          <span>Help page</span>
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>
    </div>
  </div>
</aside>
