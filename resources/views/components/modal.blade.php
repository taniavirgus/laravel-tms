@props([
    'show' => false,
    'name' => 'modal',
])

@php
  $props = $attributes->merge([
      'class' => 'relative bg-white overflow-hidden w-full max-w-xl rounded-xl mx-auto z-50',
  ]);
@endphp

<div x-data="{
    show: @js($show),
    name: '{{ $name }}'
}" x-on:open-modal.window="$event.detail == name && (show = true)"
  x-on:close-modal.window="$event.detail == name && (show = false)" x-on:keydown.escape.window="show = false"
  :class="{ 'hidden': !show }" class="fixed inset-0 z-50 grid place-items-center" x-cloak>

  <div x-show="show" class="fixed inset-0 bg-black/50 backdrop-blur-sm" x-on:click="show = false"
    x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
  </div>

  <div x-show="show" {{ $props }} x-trap.noscroll="show" x-on:close.stop="show = false"
    x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
    {{ $slot }}
  </div>
</div>
