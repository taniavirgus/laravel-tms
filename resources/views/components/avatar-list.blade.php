@props([
    'max' => 3,
    'count' => 3,
    'names' => null,
])

@php
  $props = $attributes->merge([
      'class' => 'flex items-center',
  ]);
@endphp

<div {{ $props }}>
  @foreach ($names as $name)
    @break($loop->index >= $max)
    <div class="flex-none -ml-3">
      <x-ui.avatar name="{{ $name }}" alt="{{ $name }}" class="border-2 border-white" />
    </div>
  @endforeach

  @if ($count > $max)
    <span class="ml-2 font-medium text-base-500">+ {{ $count - $max }}</span>
  @endif
</div>
