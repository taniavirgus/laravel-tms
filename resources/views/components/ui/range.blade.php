@props([
    'id' => uniqid(),
    'step' => 1,
    'max' => 100,
    'value' => 0,
    'disabled' => false,
    'required' => false,
    'tooltip' => true,
])

@php
  $props = $attributes
      ->class([
          'range-thumb',
          'focus:ring-0 focus:outline-none cursor-pointer',
          'disabled:opacity-70 disabled:cursor-not-allowed' => $disabled,
      ])
      ->merge([
          'max' => $max,
          'type' => 'range',
          'disabled' => $disabled,
          'required' => $required,
          'class' => 'w-full text-sm rounded-lg',
      ]);
@endphp

<div class="relative flex items-center w-full gap-4 py-3 group" x-data="{
    max: @js($max),
    value: @js($value),
    init() {
        this.update();
        this.$watch('value', () => {
            this.update();
        });
    },
    update() {
        const temp = (this.value / this.max) * 100;
        const color = this.color(temp);

        this.$el.style.setProperty('--range-value', temp + '%');
        this.$el.style.setProperty('--range-color', color);
    },
    color(value) {
        if (value >= 80) return '#4ade80';
        if (value >= 40) return '#fbbf24';
        return '#f87171';
    },
}">
  <div class="relative flex items-center w-full h-4 gap-4 overflow-hidden rounded-lg">
    <input {{ $props }} x-model="value" />
    <span class="absolute inset-0 w-[--range-value] h-full bg-[--range-color] pointer-events-none rounded-r-lg"></span>
  </div>

  @if ($tooltip)
    <div x-show="value > 0"
      class="absolute left-[--range-value] -top-full -translate-x-4 opacity-0 group-hover:opacity-100 transition-all z-10">
      <div class="px-3 py-2 text-sm font-medium text-white bg-base-900 rounded-xl">
        <span x-text="value"></span>
        <div class="m-0.5 tooltip-arrow" data-popper-arrow></div>
      </div>
    </div>
  @else
    <span class="text-sm font-semibold" x-text="value + '%'"></span>
  @endif
</div>
