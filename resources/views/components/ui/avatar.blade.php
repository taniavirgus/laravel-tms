@props([
    'name' => null,
    'alt' => null,
])

@php
  $avatar = 'https://i.pravatar.cc/150?u=' . urlencode($name);
  $props = $attributes->class(['rounded-full overflow-hidden flex-none'])->merge([
      'alt' => $alt,
      'src' => $avatar,
      'class' => 'size-9',
  ]);
@endphp

<img {{ $props }} />
