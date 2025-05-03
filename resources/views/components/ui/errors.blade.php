@props([
    'messages' => null,
])

@php
  $props = $attributes->merge([
      'class' => 'text-sm text-red-500',
  ]);
@endphp

<div {{ $props }}>
  @foreach ($messages as $message)
    <p>{{ $message }}</p>
  @endforeach
</div>
