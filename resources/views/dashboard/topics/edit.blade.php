<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Edit Topic</x-slot:title>
    <x-slot:description>Update topic information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card as="form" method="post" action="{{ route('topics.update', $topic) }}">
    <x-slot:header>
      <i data-lucide="book-open" class="size-5 text-primary-500"></i>
      <h5>Topic Information</h5>
    </x-slot:header>

    @csrf
    @method('PUT')
    @include('dashboard.topics.form', [
        'topic' => $topic,
    ])

    <x-slot:footer class="justify-end">
      <a href="{{ route('topics.index') }}">
        <x-ui.button variant="outline" type="button">
          <span>Cancel</span>
        </x-ui.button>
      </a>

      <x-ui.button>
        <span>Update</span>
        <i data-lucide="arrow-up-right" class="size-5"></i>
      </x-ui.button>
    </x-slot:footer>
  </x-ui.card>
</x-dashboard-layout>
