<x-dashboard-layout>
    <x-dashboard.heading>
        <x-slot:title>Dashboard</x-slot:title>
        <x-slot:description>Welcome to the dashboard</x-slot:description>
    </x-dashboard.heading>

    {{-- Card Widgets --}}
    <div class="grid grid-cols-2 gap-6 xl:grid-cols-4 mb-6">
        @foreach ($widgets as $widget)
            @continue($widget->show == false)
            <div class="p-6 border rounded-xl bg-base-50 border-base-200">
                <div class="flex flex-col gap-2">
                    <div class="flex items-start justify-between">
                        <span class="w-4/5 text-5xl font-bold">{{ $widget->value }}</span>
                        <i data-lucide="{{ $widget->icon }}" class="flex-none text-primary-500 size-5"></i>
                    </div>
                    <div class="flex flex-col text-sm">
                        <h5 class="font-medium">{{ $widget->label }}</h5>
                        <p class="truncate text-base-400">{{ $widget->description }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <x-ui.card>
                    <x-slot:header>
                        <i data-lucide="pie-chart" class="size-1 text-primary-500"></i>
                        <h5>Departemen Pie Chart</h5>
                    </x-slot:header>
                    <div class="h-56 flex justify-center items-center">
            <canvas id="departmentPie" style="max-width: 250px; max-height: 250px;"></canvas>
           </div>

        </x-ui.card>

        <x-ui.card>
            <x-slot:header>
                <i data-lucide="bar-chart-2" class="size-1 text-primary-500"></i>
                <h5>Top 5 Position</h5>
            </x-slot:header>
            <div class="h-64 flex justify-center items-center">
                <canvas id="topPositions" style="max-width: 600; max-height: 1000px;"></canvas>
            </div>
        </x-ui.card>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const departmentCtx = document.getElementById('departmentPie').getContext('2d');
                const positionCtx = document.getElementById('topPositions').getContext('2d');

                new Chart(departmentCtx, {
                    type: 'pie',
                    data: {
                        labels: @json($departmentChart->pluck('label')),
                        datasets: [{
                            data: @json($departmentChart->pluck('count')),
                            backgroundColor: ['#2563ea', '#f59e0b', '#10b981', '#ef4444', '#06b6d4', '#8b5cf6'],
                        }]
                    },
                    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
                });

                new Chart(positionCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($positionChart->pluck('label')),
                        datasets: [{
                            label: 'Jumlah Karyawan',
                            data: @json($positionChart->pluck('count')),
                            backgroundColor: '#2563ea',
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true } },
                        plugins: { legend: { display: false } }
                    }
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
