<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Help Center</x-slot:title>
    <x-slot:description>Get help with your account, application, or any other topic.</x-slot:description>
  </x-dashboard.heading>

  <div class="grid items-start gap-4">
    @foreach ($faqs as $faq)
      <x-ui.accordion>
        <x-slot:title>{{ $faq->question }}</x-slot:title>
        <x-slot:description>{{ $faq->answer }}</x-slot:description>
      </x-ui.accordion>
    @endforeach
  </div>
</x-dashboard-layout>
