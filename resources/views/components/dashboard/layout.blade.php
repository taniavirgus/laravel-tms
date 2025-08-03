@props(['widgets' => []])

<div class="min-h-screen bg-gray-100">
    <!-- Navbar dan Sidebar -->
    <x-dashboard.navbar />
    <x-dashboard.sidebar />

    <!-- Konten -->
    <main class="p-6">
        {{ $slot }}
    </main>
</div>
