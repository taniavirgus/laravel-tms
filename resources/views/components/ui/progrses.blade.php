@props([
    'max' => 100,
    'value' => 0,
    'label' => null,
    'expanded' => true,
])

@php
  $calculated = ($value / $max) * $max;
  $calculated = round($calculated, 1);

  $props = $attributes->class(['flex items-center gap-2'])->merge([
      'style' => '--progress-width: ' . $calculated . '%',
  ]);
@endphp

<div {{ $props }}>
  <div class="w-24 h-2 overflow-hidden rounded-full bg-base-200">
    <div class="h-full bg-primary-500 w-[--progress-width]"></div>
  </div>
  @if ($expanded)
    <span class="font-medium">{{ number_format($calculated, 1) }}%</span>
  @endif
</div>
