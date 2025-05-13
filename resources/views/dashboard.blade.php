<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:description>Welcome to the dashboard</x-slot:description>
  </x-dashboard.heading>

  <div class="grid grid-cols-2 gap-6 xl:grid-cols-4">
    @foreach ($widgets as $widget)
      @continue($widget->show === false)
      <div class="p-6 border rounded-xl bg-base-50 border-base-200">
        <div class="flex flex-col gap-2">
          <div class="flex items-start justify-between">
            <span class="w-4/5 text-5xl font-bold">{{ $widget->value }}</span>
            <i data-lucide="{{ $widget->icon }}" class="flex-none text-primary-500 size-5"></i>
          </div>

          <div class="flex flex-col">
            <h5 class="text-sm font-medium">{{ $widget->label }}</h5>
            <p class="text-xs truncate text-base-400">{{ $widget->description }}</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <x-ui.card>
    <x-slot:header>
      <i data-lucide="activity" class="size-5 text-primary-500"></i>
      <h5>Recent Activities</h5>
    </x-slot:header>

    <div class="grid w-full aspect-banner place-content-center">
      <div class="flex items-center gap-2 text-sm">
        <i data-lucide="activity" class="text-primary-500 size-5"></i>
        <span class="text-base-500">No recent activities</span>
      </div>
    </div>
  </x-ui.card>
</x-dashboard-layout>
