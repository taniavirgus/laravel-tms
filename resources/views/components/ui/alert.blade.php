@props([
    'status' => null,
    'variant' => 'info',
])

@php
  $props = $attributes
      ->class([
          'bg-red-50 text-red-800' => $variant === 'error',
          'bg-blue-50 text-blue-800' => $variant === 'info',
          'bg-green-50 text-green-800' => $variant === 'success',
          'bg-yellow-50 text-yellow-800' => $variant === 'warning',
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
  <div {{ $props }}>
    <i data-lucide="{{ $icon }}" class="size-5"></i>
    <div>
      <span class="font-medium">{{ $status }}</span>
      @isset($description)
        <p class="mt-1 text-base-500">{{ $description }}</p>
      @endisset
    </div>
  </div>
@endif
