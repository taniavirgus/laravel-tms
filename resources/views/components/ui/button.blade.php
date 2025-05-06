@props([
    'size' => 'default',
    'disabled' => false,
    'variant' => 'primary',
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

<button {{ $props }}>
  {{ $slot }}
</button>
