@props([
    'title' => 'Heading Title',
    'description' => 'This is the description of the heading.',
])

@php
  $props = $attributes->merge([
      'class' => 'flex flex-col gap-1',
  ]);
@endphp


<div {{ $props }}>
  <h1 class="text-3xl font-bold">{{ $title }}</h1>
  <p class="text-base-500">{{ $description }}</p>
</div>
