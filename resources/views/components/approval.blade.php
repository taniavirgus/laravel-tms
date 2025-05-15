@props([
    'id' => null,
    'title' => null,
    'route' => null,
])

@php
  $props = $attributes->exceptProps(['id', 'title', 'route'])->merge([
      'class' => 'text-blue-500',
  ]);
@endphp

<div x-data>
  <button
    x-on:click="$dispatch('trigger-approval', { 
      id: @js($id),
      title: @js($title),
      route: @js($route)
  })"
    {{ $props }}>
    Approval
  </button>
</div>

@once
  <div x-data="approve"
    x-on:trigger-approval.window="open($event.detail.id, $event.detail.title, $event.detail.route)">
    <x-modal name="confirm-approval" focusable>
      <x-ui.card as="form" method="POST" x-bind:action="route">
        @csrf
        @method('PATCH')

        <x-slot:header>
          <h5 class="text-lg font-semibold text-zinc-900">
            Change status for <span class="font-bold" x-text="title"></span>?
          </h5>
        </x-slot:header>

        <p class="mb-4 text-zinc-600 text-wrap">
          <span>
            Select the new status for this evaluation. This action will affect whether employees can be assigned or
            unassigned from this evaluation.
          </span>
          <span class="block text-red-500">Be careful, changing the status will reset the employee assignments.</span>
        </p>

        <div class="field">
          <x-ui.label for="status" value="Status" />
          <x-ui.select id="status" name="status" required>
            @foreach (\App\Enums\ApprovalType::cases() as $status)
              <option value="{{ $status->value }}">{{ $status->label() }}</option>
            @endforeach
          </x-ui.select>
          <x-ui.errors :messages="$errors->get('status')" />
        </div>

        <x-slot:footer>
          <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', 'confirm-approval')">
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

        open(id, title, route) {
          console.log("Opening approval modal:", id, title, route);
          this.id = id;
          this.title = title;
          this.route = route;
          this.$dispatch('open-modal', 'confirm-approval');
        },
      }));
    });
  </script>
@endonce
