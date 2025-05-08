@php
  $menus = array_to_object([
      [
          'name' => 'Profile',
          'url' => route('profile.edit'),
          'icon' => 'user2',
      ],
      [
          'name' => 'My likes',
          'url' => '#',
          'icon' => 'heart',
      ],
      [
          'name' => 'Collections',
          'url' => '#',
          'icon' => 'credit-card',
      ],
      [
          'name' => 'Pro version',
          'url' => '#',
          'icon' => 'bell',
      ],
  ]);

  $props = $attributes->merge([
      'type' => 'button',
      'aria-expanded' => 'false',
      'data-dropdown-toggle' => 'profile',
      'data-dropdown-placement' => 'bottom-start',
  ]);
@endphp

<button {{ $props }}>
  <x-ui.avatar name="{{ Auth::user()->name }}" alt="{{ Auth::user()->name }}" />
  <span class="sr-only">Open user menu</span>
</button>

<div id="profile"
  class="z-50 hidden w-56 overflow-hidden bg-white border divide-y divide-base-200 rounded-xl border-base-200">

  <div class="px-4 py-3 text-sm">
    <span class="block font-semibold text-base-900">{{ Auth::user()->name }}</span>
    <span class="block truncate text-base-700">{{ Auth::user()->role->label() }}</span>
  </div>

  <ul class="text-sm list-none">
    @foreach ($menus as $menu)
      <li>
        <a href="{{ $menu->url }}" class="flex items-center gap-2 px-4 py-2 hover:bg-base-100">
          <i data-lucide="{{ $menu->icon }}" class="size-4"></i>
          {{ $menu->name }}
        </a>
      </li>
    @endforeach
  </ul>

  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="block w-full p-4 text-sm text-left text-red-500 hover:text-white hover:bg-red-500">
      Sign out
    </button>
  </form>
</div>
