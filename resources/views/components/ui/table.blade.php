@props([
    'bordered' => false,
    'titile' => null,
    'action' => null,
    'head' => null,
    'body' => null,
    'foot' => null,
])

@php
  $props = $attributes->merge([
      'class' => 'relative w-full overflow-auto',
  ]);

  $props->title = $title?->attributes->class(['px-8 py-5 border-b border-base-200 font-medium'])->merge([
      'class' => 'flex items-center gap-2 bg-base-100',
  ]);

  $props->action = $action?->attributes->class(['px-8 py-5 border-b border-base-200'])->merge([
      'class' => 'flex flex-col xl:flex-row xl:items-center gap-4 bg-base-100',
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


<div class="overflow-hidden border border-base-200 rounded-xl">
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

  <div {{ $props }}>
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
</div>
