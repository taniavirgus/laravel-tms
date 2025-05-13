@props([
    'disabled' => false,
    'required' => false,
])

@php
  $props = $attributes
      ->class([
          'placeholder:text-base-400',
          'disabled:opacity-70 disabled:cursor-not-allowed' => $disabled,
          'border border-base-200 focus:ring-primary-500 focus:border-primary-500',
          'pl-12' => isset($left),
          'pr-12' => isset($right),
      ])
      ->merge([
          'class' => 'w-full text-sm px-4 p-3 rounded-lg',
          'disabled' => $disabled,
          'required' => $required,
      ]);
@endphp

<div class="relative w-full">
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

  <input {{ $props }} />
</div>
