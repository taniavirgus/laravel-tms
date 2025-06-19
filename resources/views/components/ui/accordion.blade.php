@props([
    'open' => false,
    'title' => null,
    'description' => null,
])


<div id="accordion" x-data="{ open: @js($open) }" class="bg-white border rounded-xl border-base-200">
  <button x-on:click="open = !open" class="flex items-center justify-between w-full px-6 py-4 transition"
    x-bind:class="{ 'border-b border-base-200': open }">
    <h5>{{ $title }}</h5>
    <div>
      <i data-lucide="chevron-down" class="transition size-5" x-bind:class="{ 'rotate-180': open }"></i>
      <span class="sr-only">Toggle</span>
    </div>
  </button>

  <div x-show="open" class="p-6 text-sm text-base-500" x-transition:enter="ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-4">
    {{ $description }}
  </div>
</div>
