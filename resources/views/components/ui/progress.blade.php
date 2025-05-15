@props([
    'max' => 100,
    'value' => 0,
    'label' => null,
    'expanded' => true,
])

@php
  $value = ($value / $max) * 100;
  $value = round($value, 1);

  $color = match (true) {
      $value >= 80 => '#4ade80',
      $value >= 40 => '#fbbf24',
      default => '#f87171',
  };

  $props = $attributes->class(['flex items-center gap-4 text-sm'])->merge([
      'style' => '--range-value: ' . $value . '%; --range-color: ' . $color,
  ]);
@endphp

<div {{ $props }}>
  <div class="w-full h-4 overflow-hidden rounded-full bg-base-200">
    <div class="h-full w-[--range-value] bg-[--range-color] rounded-r-lg"></div>
  </div>
  <span class="text-sm font-semibold">{{ $value }}%</span>
</div>
