@props([
    'id' => uniqid(),
    'alt' => null,
    'name' => null,
])

@php
  $avatar = 'https://i.pravatar.cc/150?u=' . urlencode($name);
  $props = $attributes->class(['rounded-full overflow-hidden flex-none'])->merge([
      'alt' => $alt,
      'src' => $avatar,
      'class' => 'size-9',
      'data-tooltip-target' => $id,
      'data-tooltip-placement' => 'top',
  ]);
@endphp

<img {{ $props }} />

<x-ui.tooltip id="{{ $id }}" tooltip="{{ $name }}" />
