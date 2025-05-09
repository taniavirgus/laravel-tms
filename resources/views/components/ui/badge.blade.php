@props([
    'value' => null,
])

@php
  $color = $value->color();
  $class = 'text-white bg-' . $color . '-500';
  $props = $attributes->class([$class])->merge([
      'class' => 'px-4 py-1 text-xs font-medium rounded-full',
  ]);
@endphp

<span {{ $props }}>
  {{ $value->label() }}
</span>
