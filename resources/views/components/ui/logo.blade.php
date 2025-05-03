@props([
    'src' => asset('images/logo.png'),
])

@php
  $props = $attributes->merge([
      'class' => 'w-full',
      'alt' => 'Application Logo',
      'src' => $src,
  ]);
@endphp

<img {{ $props }} />
