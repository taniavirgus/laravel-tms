@props([
    'id' => null,
    'title' => null,
    'route' => null,
])

<div x-data>
  <button
    x-on:click="$dispatch('trigger', { 
      id: @js($id),
      title: @js($title),
      route: @js($route)
  })"
    class="text-red-600">
    Delete
  </button>
</div>

@once
  <div x-data="confirmation" x-on:trigger.window="open($event.detail.id, $event.detail.title, $event.detail.route)">
    <x-modal name="confirm-deletion" focusable>
      <x-ui.card as="form" method="POST" x-bind:action="route">
        @csrf
        @method('DELETE')

        <x-slot:header>
          <h5 class="text-lg font-semibold text-zinc-900">
            Are you sure you want to delete <span class="font-bold" x-text="title"></span>?
          </h5>
        </x-slot:header>

        <p class="text-zinc-600 text-wrap">
          Be careful! This action cannot be undone. All of the data will be permanently removed,
          including all related data, make sure you have a backup of the data before proceeding.
        </p>

        <x-slot:footer>
          <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', 'confirm-deletion')">
            Cancel
          </x-ui.button>

          <x-ui.button variant="destructive" type="submit" class="ml-2">
            Confirm Delete
          </x-ui.button>
        </x-slot:footer>
      </x-ui.card>
    </x-modal>
  </div>

  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('confirmation', () => ({
        id: null,
        title: null,
        route: null,

        open(id, title, route) {
          console.log("Opening modal:", id, title, route);
          this.id = id;
          this.title = title;
          this.route = route;
          this.$dispatch('open-modal', 'confirm-deletion');
        },
      }));
    });
  </script>
@endonce
