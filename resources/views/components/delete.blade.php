@props([
    'id' => null,
    'title' => null,
    'route' => null,
])

<button x-data
  x-on:click.prevent="
  $dispatch('open-modal', 'confirm-deletion');
  $dispatch('set-delete-data', {
    id: {{ $id }},
    title: '{{ $title }}',
    route: '{{ $route }}'
  });
"
  class="text-red-600">
  Delete
</button>

@once
  <div x-data="{ id: null, title: null, route: null }"
    x-on:set-delete-data.window="
  id = $event.detail.id;
  title = $event.detail.title;
  route = $event.detail.route;
">
    <x-modal name="confirm-deletion" focusable>
      <x-ui.card as="form" method="POST" x-bind:action="route">
        @csrf
        @method('DELETE')

        <x-slot:header>
          <h5 class="text-lg font-semibold text-zinc-900">
            Are you sure you want to delete <span class="font-bold" x-text="title"></span>?
          </h5>
        </x-slot:header>

        <div class="form">
          <p class="mt-2 text-sm text-zinc-600">
            This action cannot be undone. All of the data will be permanently removed.
          </p>
        </div>

        <x-slot:footer>
          <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close')">
            Cancel
          </x-ui.button>

          <x-ui.button variant="destructive" type="submit" class="ml-2">
            Confirm Delete
          </x-ui.button>
        </x-slot:footer>
      </x-ui.card>
    </x-modal>
  </div>

@endonce
