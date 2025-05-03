@props([
        //
    ])

@php
  $props = $attributes
      ->class([
          'fixed top-0 left-0 z-40 h-screen transition-transform -translate-x-full bg-white border-r border-zinc-200 md:translate-x-0',
      ])
      ->merge([
          'class' => 'w-full',
          'aria-label' => 'Sidenav',
          'id' => 'drawer-navigation',
      ]);

  $menus = array_to_object([
      [
          'name' => 'Overview',
          'icon' => 'chart-pie',
          'href' => '#',
      ],
      [
          'name' => 'Pages',
          'icon' => 'file-text',
          'href' => '#',
          'submenus' => [
              ['name' => 'Settings', 'href' => '#'],
              ['name' => 'Kanban', 'href' => '#'],
              ['name' => 'Calendar', 'href' => '#'],
          ],
      ],
      [
          'name' => 'Sales',
          'icon' => 'shopping-cart',
          'href' => '#',
          'submenus' => [
              ['name' => 'Products', 'href' => '#'],
              ['name' => 'Billing', 'href' => '#'],
              ['name' => 'Invoice', 'href' => '#'],
          ],
      ],
      [
          'name' => 'Messages',
          'icon' => 'message-circle',
          'href' => '#',
          'count' => 4,
      ],
      [
          'name' => 'Authentication',
          'icon' => 'lock',
          'href' => '#',
          'submenus' => [
              ['name' => 'Sign In', 'href' => '#'],
              ['name' => 'Sign Up', 'href' => '#'],
              ['name' => 'Forgot Password', 'href' => '#'],
          ],
      ],
  ]);

  $navigations = array_to_object([
      [
          'name' => 'Profile',
          'icon' => 'user2',
          'href' => '#',
      ],
      [
          'name' => 'Settings',
          'icon' => 'settings',
          'href' => '#',
      ],
      [
          'name' => 'Help',
          'icon' => 'help-circle',
          'href' => '#',
      ],
  ]);
@endphp

<aside {{ $props }}>
  <div class="h-full overflow-y-auto">
    <form action="#" method="GET" class="mb-2 md:hidden">
      <label for="sidebar-search" class="sr-only">Search</label>
      <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <svg class="w-5 h-5 text-zinc-500 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z">
            </path>
          </svg>
        </div>
        <input type="text" name="search" id="sidebar-search"
          class="block w-full p-2 pl-10 text-sm font-medium border rounded-lg border-zinc-200 bg-zinc-50 focus:ring-primary-500 focus:border-primary-500 "
          placeholder="Search" />
      </div>
    </form>

    <ul class="space-y-2">
      @foreach ($menus as $menu)
        @isset($menu->submenus)
          <li>
            <button type="button"
              class="flex items-center w-full p-2 text-sm font-medium rounded-lg group hover:bg-zinc-100 "
              aria-controls="{{ $menu->name }}" data-collapse-toggle="{{ $menu->name }}">
              <i data-lucide="{{ $menu->icon }}" class="size-5 text-primary-500"></i>
              <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $menu->name }}</span>
              <i data-lucide="chevron-down" class="size-5"></i>
            </button>

            <ul id="{{ $menu->name }}" class="hidden py-2 space-y-2">
              @foreach ($menu->submenus as $submenu)
                <li>
                  <a href="{{ $submenu->href }}"
                    class="flex items-center w-full p-2 text-sm font-medium rounded-lg pl-11 group hover:bg-zinc-100">
                    {{ $submenu->name }}
                  </a>
                </li>
              @endforeach
            </ul>
          </li>
        @else
          <li>
            <a href="{{ $menu->href }}"
              class="flex items-center p-2 text-sm font-medium rounded-lg hover:bg-zinc-100 group">
              <i data-lucide="{{ $menu->icon }}" class="size-5 text-primary-500"></i>
              <span class="flex-1 ml-3 whitespace-nowrap">{{ $menu->name }}</span>
              @isset($menu->count)
                <span
                  class="inline-flex items-center justify-center w-5 h-5 text-xs font-semibold rounded-full text-primary-800 bg-primary-100">
                  {{ $menu->count }}
                </span>
              @endisset
            </a>
          </li>
        @endisset
      @endforeach
    </ul>

    <hr class="my-4 border-zinc-100" />

    <ul class="space-y-2">
      @foreach ($navigations as $navigation)
        <li>
          <a href="{{ $navigation->href }}"
            class="flex items-center p-2 text-sm font-medium rounded-lg hover:bg-zinc-100 group">
            <i data-lucide="{{ $navigation->icon }}" class="size-5 text-primary-500"></i>
            <span class="ml-3">{{ $navigation->name }}</span>
          </a>
        </li>
      @endforeach
    </ul>
  </div>

  <div class="absolute bottom-0 left-0 z-20 justify-center hidden w-full gap-4 p-4 item-center lg:flex">
    <a href="#" data-tooltip-target="tooltip-settings"
      class="inline-flex justify-center p-2 rounded cursor-pointer text-zinc-500 hover hover:bg-zinc-100">
      <i data-lucide="settings" class="size-5 text-primary-500"></i>
    </a>

    <a href="#" data-tooltip-target="tooltip-help"
      class="inline-flex justify-center p-2 rounded cursor-pointer text-zinc-500 hover hover:bg-zinc-100">
      <i data-lucide="help-circle" class="size-5 text-primary-500"></i>
    </a>

    <div id="tooltip-settings" role="tooltip"
      class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 rounded-lg opacity-0 bg-zinc-900 tooltip">
      Settings page
      <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

    <div id="tooltip-help" role="tooltip"
      class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 rounded-lg opacity-0 bg-zinc-900 tooltip">
      Help page
      <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
  </div>
</aside>
