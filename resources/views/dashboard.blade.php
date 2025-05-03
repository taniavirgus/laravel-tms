<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Dashboard</x-slot:title>
    <x-slot:description>Welcome to the dashboard</x-slot:description>
  </x-dashboard.heading>

  <div class="grid grid-cols-3 gap-6">
    @foreach (range(1, 20) as $i)
      <div class="border rounded-lg bg-base-50 aspect-video border-base-200"></div>
    @endforeach
  </div>
</x-dashboard-layout>
