@props([
    'as' => 'div',
    'header' => null,
    'footer' => null,
])

@php
  $props = $attributes->class(['relative overflow-hidden', 'bg-white border rounded-xl border-base-200'])->merge([
      'class' => '',
  ]);

  $props->header = $header?->attributes->class([
      'flex flex-col items-start justify-start',
      'px-8 py-5 border-b bg-zinc-100 border-base-200',
  ]);

  $props->footer = $footer?->attributes->class([
      'flex item-center gap-2 justify-end flex-none',
      'px-8 py-4 border-t border-base-200',
  ]);
@endphp

<{{ $as }} {{ $props }}>
  @isset($header)
    <div {{ $props->header }}>
      {{ $header }}
    </div>
  @endisset

  <div class="p-8">
    {{ $slot }}
  </div>

  @isset($footer)
    <div {{ $props->footer }}>
      {{ $footer }}
    </div>
  @endisset
  </{{ $as }}>
