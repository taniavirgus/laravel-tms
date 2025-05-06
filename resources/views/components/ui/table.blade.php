@props([
    'bordered' => false,
    'titile' => null,
    'action' => null,
    'head' => null,
    'body' => null,
    'foot' => null,
])

@php
  $props = $attributes->class(['border border-base-200'])->merge([
      'class' => 'relative w-full overflow-auto content rounded-xl',
  ]);

  $props->title = $title?->attributes->class(['px-8 py-5 border-b border-base-200 font-medium'])->merge([
      'class' => 'flex items-center gap-2 bg-base-100',
  ]);

  $props->action = $action?->attributes->class(['px-8 py-5 border-b border-base-200'])->merge([
      'class' => 'flex items-center gap-4 bg-base-100',
  ]);

  $props->head = $head?->attributes->merge([
      'class' => 'bg-base-50',
  ]);

  $props->body = $body?->attributes->merge([
      'class' => 'bg-white divide-y divide-base-200',
  ]);

  $props->foot = $foot?->attributes->merge([
      'class' => 'bg-base-50',
  ]);
@endphp


<div {{ $props }}>
  @isset($title)
    <div {{ $props->title }}>
      {{ $title }}
    </div>
  @endisset

  @isset($action)
    <div {{ $props->action }}>
      {{ $action }}
    </div>
  @endisset

  <table>
    @isset($head)
      <thead {{ $props->head }}>
        {{ $head }}
      </thead>
    @endisset

    @isset($body)
      <tbody {{ $props->body }}>
        {{ $body }}
      </tbody>
    @endisset

    @isset($foot)
      <tfoot {{ $props->foot }}>
        {{ $foot }}
      </tfoot>
    @endisset
  </table>
</div>
