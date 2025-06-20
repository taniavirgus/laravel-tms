<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Talent Matrix</x-slot:title>
    <x-slot:description>Nine-box grid showing employee distribution based on potential and performance</x-slot:description>
  </x-dashboard.heading>

  <div class="grid grid-cols-3 gap-6">
    @foreach ($segments as $segment)
      @php
        $color = $segment->type->color();
        $color = str_replace('bg-', 'text-', $color);
      @endphp

      <a href="{{ route('segments.show', $segment->type->value) }}">
        <x-ui.card>
          <x-slot:header class="justify-between">
            <h5 class="font-medium">{{ $segment->type->label() }}</h5>
            <i data-lucide="trending-up" class="size-5 {{ $color }}"></i>
          </x-slot:header>

          <div class="flex flex-col items-center justify-center gap-2">
            <span class="text-5xl font-bold">{{ $segment->count }}</span>
            <span class="text-sm text-base-500">Employees</span>
          </div>

          <x-slot:footer>
            <p class="text-sm text-base-500">{{ $segment->type->description() }}</p>
          </x-slot:footer>
        </x-ui.card>
      </a>
    @endforeach
  </div>
</x-dashboard-layout>
