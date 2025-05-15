@props([
    'id' => uniqid(),
    'size' => 'default',
    'disabled' => false,
    'variant' => 'primary',
    'tooltip' => 'Tooltip',
])

@php
  $props = $attributes
      ->class([
          'size-icon' => $size === 'icon',
          'px-6 p-3' => $size === 'default',
          'flex-none flex items-center justify-center gap-2',
          'disabled:opacity-70 disabled:cursor-not-allowed' => $disabled,
          'border-transparent text-white bg-primary-500 both:bg-primary-600' => $variant === 'primary',
          'border-transparent text-zinc-900 bg-base-200 both:bg-base-300' => $variant === 'secondary',
          'border-transparent text-white bg-red-500 both:bg-red-600' => $variant === 'destructive',
          'border-base-200 text-base-900 bg-white both:bg-base-100' => $variant === 'outline',
          'border-transparent text-base-900 bg-white both:bg-base-100' => $variant === 'ghost',
      ])
      ->merge([
          'type' => 'submit',
          'disabled' => $disabled,
          'class' => 'rounded-lg text-sm font-medium focus:outline-none border',
      ]);
@endphp

<button {{ $props }} @if ($size === 'icon') data-tooltip-target="{{ $id }}" @endif>
  {{ $slot }}
</button>

@if ($size === 'icon')
  <div id="{{ $id }}" role="tooltip"
    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
    {{ $tooltip }}
    <div class="tooltip-arrow" data-popper-arrow></div>
  </div>
@endif
