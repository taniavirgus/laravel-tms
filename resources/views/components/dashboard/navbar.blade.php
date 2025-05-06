<nav class="sticky top-0 z-10 bg-white border-b border-base-200">
  <div class="h-20 px-8">
    <div class="flex items-center justify-between h-full">
      <div class="flex items-center gap-4">
        <x-ui.button class="flex rounded-full md:hidden" variant="ghost" data-drawer-target="sidebar"
          data-drawer-toggle="sidebar" aria-controls="sidebar" size="icon">
          <i data-lucide="menu" class="size-5"></i>
          <span class="sr-only">Toggle sidebar</span>
        </x-ui.button>
        <span>Dashboard</span>
      </div>

      <div class="flex items-center gap-2">
        <x-dashboard.notification />
        <x-dashboard.profile />
      </div>
    </div>
  </div>
</nav>
