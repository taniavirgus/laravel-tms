@props([
    'messages' => null,
])

@php
  $props = $attributes->merge([
      'class' => 'text-sm text-red-500',
  ]);
@endphp

@if ($messages && count($messages) > 0)
  <div {{ $props }}>
    @foreach ($messages as $message)
      <p>{{ $message }}</p>
    @endforeach
  </div>
@endif
