@props([
    'title' => 'Heading Title',
    'description' => 'This is the description of the heading.',
])

@php
  $props = $attributes->merge([
      'class' => 'flex flex-col gap-1',
  ]);

  $props->title = $title->attributes->merge([
      'class' => 'text-3xl font-bold',
  ]);
@endphp


<div {{ $props }}>
  <h2 {{ $props->title }}>{{ $title }}</h2>
  <p class="text-base-500">{{ $description }}</p>
</div>
