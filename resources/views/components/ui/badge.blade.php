@props([
    'value' => null,
])

@php
  if ($value instanceof \UnitEnum) {
      $color = $value->color();
      $label = $value->label();
  } else {
      $color = 'bg-primary-500';
      $label = $value;
  }

  $props = $attributes->class(['px-2 py-1 text-white text-xs font-medium rounded-full', $color]);
@endphp

<span {{ $props }}>
  {{ $label }}
</span>
