@props([
    'id' => null,
    'title' => null,
    'route' => null,
    'score' => 0,
    'notes' => null,
])

@php
  $props = $attributes->exceptProps(['id', 'title', 'route'])->merge([
      'class' => 'text-blue-500',
  ]);
@endphp

<div x-data>
  <button
    x-on:click="$dispatch('trigger-score', { 
      id: @js($id),
      title: @js($title),
      route: @js($route),
      score: @js($score),
      notes: @js($notes)
  })"
    {{ $props }}>
    Score
  </button>
</div>

@once
  <div x-data="approve"
    x-on:trigger-score.window="open(
      $event.detail.id, 
      $event.detail.title, 
      $event.detail.route, 
      $event.detail.score, 
      $event.detail.notes
    )">
    <x-modal name="confirm-score" focusable>
      <x-ui.card as="form" method="POST" x-bind:action="route">
        @csrf
        @method('PATCH')

        <x-slot:header>
          <h5 class="text-lg font-semibold text-zinc-900">
            Update score for <span class="font-bold" x-text="title"></span>
          </h5>
        </x-slot:header>

        <div class="form">
          <div class="field">
            <x-ui.label for="score" value="Score" />
            <x-ui.input type="number" class="appearance-none" name="score" id="score" x-bind:value="score"
              required>
              <x-slot:right>
                <span class="text-sm text-base-500">of 100</span>
              </x-slot:right>
            </x-ui.input>
            <x-ui.errors :messages="$errors->get('score')" />
          </div>

          <div class="field">
            <x-ui.label for="notes" value="Notes" />
            <x-ui.textarea id="notes" name="notes" rows="4" x-text="notes"></x-ui.textarea>
            <x-ui.errors :messages="$errors->get('notes')" />
          </div>
        </div>

        <x-slot:footer>
          <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', 'confirm-score')">
            Cancel
          </x-ui.button>

          <x-ui.button variant="primary" type="submit" class="ml-2">
            Confirm
          </x-ui.button>
        </x-slot:footer>
      </x-ui.card>
    </x-modal>
  </div>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('approve', () => ({
        id: null,
        title: null,
        route: null,
        score: 0,
        notes: null,

        open(id, title, route, score, notes) {
          console.log("Opening approval modal:", id, title, route);
          this.id = id;
          this.title = title;
          this.route = route;
          this.score = score;
          this.notes = notes;
          this.$dispatch('open-modal', 'confirm-score');
        },
      }));
    });
  </script>
@endonce
