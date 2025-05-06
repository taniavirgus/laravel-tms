<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:description>Welcome to the dashboard</x-slot:description>
  </x-dashboard.heading>

  <div class="grid gap-6 lg:grid-cols-2 xl:grid-cols-3">
    @foreach (range(1, 6) as $i)
      <div class="border rounded-lg bg-base-50 aspect-video border-base-200"></div>
    @endforeach
  </div>
</x-dashboard-layout>
