@props([
    'status' => null,
    'duration' => 5000,
    'variant' => 'info',
    'persistent' => false,
])

@php
  $props = $attributes
      ->class([
          'border border-red-200 bg-red-50 text-red-800' => $variant === 'error',
          'border border-blue-200 bg-blue-50 text-blue-800' => $variant === 'info',
          'border border-green-200 bg-green-50 text-green-800' => $variant === 'success',
          'border border-yellow-200 bg-yellow-50 text-yellow-800' => $variant === 'warning',
      ])
      ->merge([
          'class' => 'p-4 rounded-lg mb-4 text-sm flex items-start gap-2',
      ]);

  $icon = match ($variant) {
      'info' => 'info',
      'success' => 'circle-check',
      'error' => 'alert-triangle',
      'warning' => 'alert-triangle',
  };
@endphp

@if ($status)
  <div x-data="{
      show: true,
      duration: @js($duration),
      persistent: @js($persistent),
  }" x-init="if (!persistent) {
      setTimeout(() => {
          show = false
      }, duration)
  }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" {{ $props }}>

    <i data-lucide="{{ $icon }}" class="size-5"></i>

    <div class="flex-1">
      <div class="flex items-center justify-between">
        <span class="font-medium">{{ $status }}</span>

        <button x-on:click="show = false" type="button" class="ml-auto text-gray-400 hover:text-gray-500">
          <i data-lucide="x" class="size-4"></i>
        </button>
      </div>

      @isset($description)
        <p class="mt-1 text-base-500">{{ $description }}</p>
      @endisset
    </div>
  </div>
@endif
