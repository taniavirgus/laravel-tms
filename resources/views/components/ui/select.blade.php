@props([
    'disabled' => false,
])

@php
  $props = $attributes
      ->class([
          'text-sm',
          'placeholder:text-base-400',
          'disabled:opacity-70 disabled:cursor-not-allowed' => $disabled,
          'pl-12' => isset($left),
          'pr-12' => isset($right),
      ])
      ->merge([
          'class' => 'w-full px-4 p-3 border border-base-200 focus:border-primary-500 rounded-lg',
          'disabled' => $disabled,
      ]);
@endphp

<div class="relative">
  @isset($left)
    <div class="absolute -translate-y-1/2 top-1/2 left-4">
      {{ $left }}
    </div>
  @endisset

  @isset($right)
    <div class="absolute -translate-y-1/2 top-1/2 right-4">
      {{ $right }}
    </div>
  @endisset

  <select {{ $props }}>
    {{ $slot }}
  </select>
</div>
