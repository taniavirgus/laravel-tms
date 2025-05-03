@props([
    'value' => null,
    'required' => false,
])

@php
  $props = $attributes
      ->class([
          'after:content-["*"] after:ml-1 after:text-red-500' => $required,
      ])
      ->merge([
          'class' => 'block text-sm font-medium mb-1',
          'required' => $required,
      ]);
@endphp

<label {{ $props }}>
  {{ $value }}
</label>
