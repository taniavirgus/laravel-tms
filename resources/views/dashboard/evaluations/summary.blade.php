<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Evaluation Summary</x-slot:title>
    <x-slot:description>View evaluation summary in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-4">
    <x-ui.card>
      <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-sm font-medium">Total Evaluations</p>
        <i data-lucide="check-circle" class="size-5 text-primary-500"></i>
      </div>
      <h3 class="text-4xl font-bold">{{ $evaluation_count }}</h3>
    </x-ui.card>

    <x-ui.card>
      <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-sm font-medium">Average Potential</p>
        <i data-lucide="users" class="size-5 text-primary-500"></i>
      </div>
      <h3 class="text-4xl font-bold">{{ number_format($average_potential, 1) }}</h3>
    </x-ui.card>

    <x-ui.card>
      <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-sm font-medium">Average Performance</p>
        <i data-lucide="trending-up" class="size-5 text-primary-500"></i>
      </div>
      <h3 class="text-4xl font-bold">{{ number_format($average_performance, 1) }}</h3>
    </x-ui.card>

    <x-ui.card>
      <div class="flex items-center justify-between gap-2 mb-2">
        <p class="text-sm font-medium">Average Score</p>
        <i data-lucide="bar-chart-4" class="size-5 text-primary-500"></i>
      </div>
      <h3 class="text-4xl font-bold">{{ number_format($average_score, 1) }}</h3>
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
            <option value="{{ $department->id }}" @selected(request()->get('department_id') == $department->id)>{{ $department->name }}</option>
          @endforeach
        </x-ui.select>

        <x-ui.select name="topic_id" onchange="this.form.submit()">
          <option value="">All Topics</option>
          @foreach ($topics as $topic)
            <option value="{{ $topic->id }}" @selected(request()->get('topic_id') == $topic->id)>{{ $topic->name }}</option>
          @endforeach
        </x-ui.select>
      </form>
    </x-slot:action>

    <x-slot:head>
      <x-ui.tooltip id="training" tooltip="Number of training assigned to the employee" />
      <x-ui.tooltip id="evaluation" tooltip="Number of evaluation assigned to the employee" />
      <x-ui.tooltip id="feedback" tooltip="Average feedback score" />
      <x-ui.tooltip id="performance" tooltip="Average of employee evaluation score" />
      <x-ui.tooltip id="potential" tooltip="Average of employee feedback and training score" />
      <x-ui.tooltip id="average" tooltip="Average of potential and performance score" />

      <th>Rank</th>
      <th>Name</th>
      <th>Department</th>
      <th data-tooltip-target="training">Training</th>
      <th data-tooltip-target="evaluation">Evaluation</th>
      <th data-tooltip-target="feedback">Feedback</th>
      <th data-tooltip-target="performance">Performance</th>
      <th data-tooltip-target="potential">Potential</th>
      <th data-tooltip-target="average">Average</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($top_performers as $employee)
        <tr>
          <td class="w-10">{{ $top_performers->firstItem() + $loop->index }}</td>
          <td>
            <div class="flex items-center gap-2">
              <x-ui.avatar name="{{ $employee->name }}" alt="{{ $employee->name }}" />
              <span>{{ $employee->name }}</span>
            </div>
          </td>
          <td>{{ $employee->department->name }}</td>
          <td class="font-semibold">{{ $employee->matrix->training_count }}</td>
          <td class="font-semibold">{{ $employee->matrix->evaluation_count }}</td>
          <td class="font-semibold">{{ round($employee->matrix->feedback_score) }}</td>
          <td class="font-semibold">{{ round($employee->matrix->performance_score) }}</td>
          <td class="font-semibold">{{ round($employee->matrix->potential_score) }}</td>
          <td class="font-semibold">{{ round($employee->matrix->average_score) }}</td>
          <td>
            <a href="{{ route('employees.show', $employee->id) }}" class="text-primary-500">
              View
            </a>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="10" />
      @endforelse
    </x-slot:body>

    <x-slot:footer>
      <div class="flex flex-col">
        <span>Notes</span>
        <p class="text-sm text-gray-500">
          The top performers are calculated based on the average score of potential and performance.
        </p>
      </div>
    </x-slot:footer>
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
            labels: @json($chart->departments->pluck('label')),
            datasets: [{
              label: 'Average Score',
              data: @json($chart->departments->pluck('average_score')),
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
            labels: @json($chart->topics->pluck('label')),
            datasets: [{
              label: 'Average Score',
              data: @json($chart->topics->pluck('average_score')),
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
