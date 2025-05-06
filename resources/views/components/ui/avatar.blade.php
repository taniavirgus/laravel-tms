@props([
    'name' => null,
    'alt' => null,
])

@php
  $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=FFFFFF&background=3b82f6&size=128';

  $props = $attributes->class(['rounded-full overflow-hidden'])->merge([
      'alt' => $alt,
      'src' => $avatar,
      'class' => 'size-9',
  ]);
@endphp

<img {{ $props }} />
