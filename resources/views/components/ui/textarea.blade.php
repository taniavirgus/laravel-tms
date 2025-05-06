@props([
    'rows' => 3,
    'disabled' => false,
])

@php
  $props = $attributes
      ->class(['text-sm', 'placeholder:text-base-400', 'disabled:opacity-70 disabled:cursor-not-allowed' => $disabled])
      ->merge([
          'class' => 'w-full px-4 p-3 border border-base-200 focus:border-primary-500 rounded-lg',
          'disabled' => $disabled,
      ]);
@endphp

<textarea {{ $props }} rows="{{ $rows }}">{{ $slot }}</textarea>
