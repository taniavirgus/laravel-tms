@props([
    'colspan' => 5,
])

@php
  $props = $attributes->merge([
      'colspan' => $colspan,
      'class' => 'w-full py-10 text-base-400',
  ]);
@endphp

<tr>
  <td {{ $props }}>
    <div class="flex items-center justify-center gap-2">
      <i data-lucide="info" class="size-5"></i>
      <span>No data found</span>
    </div>
  </td>
</tr>
