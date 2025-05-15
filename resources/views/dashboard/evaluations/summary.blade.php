<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Evaluation Summary</x-slot:title>
    <x-slot:description>View evaluation summary in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-4">
    <x-ui.card>
      <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-sm font-medium">Overall Average Score</p>
        <i data-lucide="bar-chart-4" class="size-5 text-primary-500"></i>
      </div>
      <h3 class="text-4xl font-bold">{{ number_format($average_score, 1) }}</h3>
    </x-ui.card>

    <x-ui.card>
      <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-sm font-medium">Total Evaluations</p>
        <i data-lucide="check-circle" class="size-5 text-primary-500"></i>
      </div>
      <h3 class="text-4xl font-bold">{{ $evaluation_count }}</h3>
    </x-ui.card>

    <x-ui.card>
      <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-sm font-medium">Employees Evaluated</p>
        <i data-lucide="users" class="size-5 text-primary-500"></i>
      </div>
      <h3 class="text-4xl font-bold">{{ $employees_count }}</h3>
    </x-ui.card>

    <x-ui.card>
      <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-sm font-medium">Completion Rate</p>
        <i data-lucide="percent" class="size-5 text-primary-500"></i>
      </div>
      <h3 class="text-4xl font-bold">{{ $completion_rate }}%</h3>
    </x-ui.card>
  </div>

  <div class="grid gap-6 xl:grid-cols-2">
    <x-ui.card>
      <x-slot:header>
        <i data-lucide="building-2" class="size-5 text-primary-500"></i>
        <h5>Department Performance</h5>
      </x-slot:header>

      <x-slot:content class="p-4 h-96">
        <canvas id="department"></canvas>
      </x-slot:content>
    </x-ui.card>

    <x-ui.card>
      <x-slot:header>
        <i data-lucide="book-open" class="size-5 text-primary-500"></i>
        <h5>Evaluation by Topic</h5>
      </x-slot:header>

      <x-slot:content class="p-4 h-96">
        <canvas id="topic"></canvas>
      </x-slot:content>
    </x-ui.card>
  </div>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="trophy" class="size-5 text-primary-500"></i>
      <h4>Top Performers</h4>
    </x-slot:title>

    <x-slot:action class="justify-between">
      <form action="{{ route('evaluations.summary') }}" method="GET"
        class="flex flex-col gap-2 xl:flex-row xl:items-center">
        <x-ui.select name="department_id" onchange="this.form.submit()">
          <option value="">All Departments</option>
          @foreach ($departments as $department)
            <option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>{{ $department->name }}</option>
          @endforeach
        </x-ui.select>

        <x-ui.select name="topic_id" onchange="this.form.submit()">
          <option value="">All Topics</option>
          @foreach ($topics as $topic)
            <option value="{{ $topic->id }}" @selected(request('topic_id') == $topic->id)>{{ $topic->name }}</option>
          @endforeach
        </x-ui.select>
      </form>
    </x-slot:action>

    <x-slot:head>
      <th>Rank</th>
      <th>Name</th>
      <th>Department</th>
      <th>Position</th>
      <th>Overall score</th>
      <th>Total Evaluations</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($top_performers as $index => $employee)
        <tr>
          <td class="w-10">{{ $index + 1 }}</td>
          <td>
            <a href="{{ route('employees.show', $employee->id) }}" class="flex items-center gap-2">
              <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
              <span>{{ $employee->name }}</span>
            </a>
          </td>
          <td>{{ $employee->department->name }}</td>
          <td>{{ $employee->position->name }}</td>
          <td class="font-semibold">{{ round($employee->average_score) }}%</td>
          <td>{{ $employee->evaluations_count }}</td>
        </tr>
      @empty
        <x-ui.empty colspan="6" />
      @endforelse
    </x-slot:body>
  </x-ui.table>

  {{ $top_performers->links() }}

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const colors = {
          primary: '#2563ea',
          secondary: '#ffd200',
          success: '#10b981',
          warning: '#f59e0b',
          danger: '#ef4444',
          info: '#06b6d4'
        };

        const departmentCtx = document.getElementById('department').getContext('2d');

        new Chart(departmentCtx, {
          type: 'bar',
          indexAxis: 'y',
          data: {
            labels: @json($department_names),
            datasets: [{
              label: 'Average Score',
              data: @json($department_scores),
              backgroundColor: colors.primary,
              borderWidth: 0,
              borderRadius: 4
            }]
          },
          options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: {
                min: 0,
                max: 100
              }
            },
            plugins: {
              legend: {
                display: false
              }
            },
          }
        });

        const topicCtx = document.getElementById('topic').getContext('2d');

        new Chart(topicCtx, {
          type: 'bar',
          data: {
            labels: @json($topic_names),
            datasets: [{
              label: 'Average Score',
              data: @json($topic_scores),
              backgroundColor: colors.secondary,
              borderWidth: 0,
              borderRadius: 4
            }]
          },
          options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              x: {
                min: 0,
                max: 100
              }
            },
            plugins: {
              legend: {
                display: false
              },
            },
          }
        });
      });
    </script>
  @endpush
</x-dashboard-layout>
