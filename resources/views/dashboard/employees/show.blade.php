<x-dashboard-layout>
  <x-dashboard.heading>
    <x-slot:title>Employee Details</x-slot:title>
    <x-slot:description>View employee information in {{ config('app.name') }}</x-slot:description>
  </x-dashboard.heading>

  <x-ui.card>
    <x-slot:header>
      <i data-lucide="user" class="size-5 text-primary-500"></i>
      <h5>Employee Details</h5>
    </x-slot:header>

    <div class="form xl:grid-cols-2">
      <dl>
        <dt class="text-sm font-medium text-base-500">Name</dt>
        <dd>{{ $employee->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Email</dt>
        <dd>{{ $employee->email }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Phone</dt>
        <dd>{{ $employee->phone }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Department</dt>
        <dd>{{ $employee->department->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Position</dt>
        <dd>{{ $employee->position->name }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Status</dt>
        <dd>
          <x-ui.badge :value="$employee->status" />
        </dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Gender</dt>
        <dd>{{ $employee->gender->label() }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Religion</dt>
        <dd>{{ $employee->religion->label() }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Birth Date</dt>
        <dd>{{ $employee->birthdate->format('d M Y') }}</dd>
      </dl>

      <dl class="col-span-full">
        <dt class="text-sm font-medium text-base-500">Address</dt>
        <dd>
          <p>{{ $employee->address }}</p>
        </dd>
      </dl>
    </div>

    <x-slot:footer class="justify-end">
      <a href="{{ route('employees.index') }}">
        <x-ui.button variant="outline" type="button">
          <span>Back</span>
        </x-ui.button>
      </a>

      @can('update', $employee)
        <a href="{{ route('employees.edit', $employee) }}">
          <x-ui.button>
            <span>Edit</span>
            <i data-lucide="arrow-up-right" class="size-5"></i>
          </x-ui.button>
        </a>
      @endcan
    </x-slot:footer>
  </x-ui.card>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
      <h4>Assigned Evaluations</h4>
    </x-slot:title>

    <x-slot:head>
      <th>ID</th>
      <th>Name</th>
      <th>Topic</th>
      <th>Department</th>
      <th>Weight</th>
      <th>Point</th>
      <th>Employee Score</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($evaluations as $evaluation)
        <tr>
          <td class="w-10">{{ $evaluation->id }}</td>
          <td>{{ $evaluation->name }}</td>
          <td>{{ $evaluation->topic->name }}</td>
          <td>{{ $evaluation->department->name }}</td>
          <td>{{ $evaluation->weight }}%</td>
          <td>{{ $evaluation->point }}</td>
          @can('score', $employee)
            <td class="w-36 min-w-28">
              <label for="scores[{{ $evaluation->id }}]" class="sr-only">Score</label>
              <x-ui.input type="number" class="appearance-none" name="scores[{{ $evaluation->id }}]"
                id="scores[{{ $evaluation->id }}]" max="{{ $evaluation->target }}"
                value="{{ $evaluation->pivot->score }}">
                <x-slot:right>
                  <span class="text-sm text-base-500">of {{ $evaluation->target }}</span>
                </x-slot:right>
              </x-ui.input>
            </td>
          @else
            <td>{{ $evaluation->pivot->score }} / {{ $evaluation->target }}</td>
          @endcan
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('evaluations.show', $evaluation) }}" class="text-primary-500">
                View
              </a>
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="8" message="No evaluations assigned to this employee" />
      @endforelse
    </x-slot:body>

    @can('score', $employee)
      <x-slot:form action="{{ route('employees.score', $employee) }}" method="POST" id="form">
        @csrf
        @method('PATCH')
      </x-slot:form>

      <x-slot:footer class="justify-end">
        <x-ui.button type="submit" form="form">
          <span>Update</span>
          <i data-lucide="arrow-up-right" class="size-5"></i>
        </x-ui.button>
      </x-slot:footer>
    @endcan
  </x-ui.table>

  <x-ui.card>
    <x-slot:header>
      <i data-lucide="file-text" class="size-5 text-primary-500"></i>
      <h5>Employee Feedback</h5>
    </x-slot:header>

    <div class="form xl:grid-cols-2">
      <dl>
        <dt class="text-sm font-medium text-base-500">Teamwork</dt>
        <dd><x-ui.progress class="py-3" :value="$employee->feedback->teamwork" /></dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Communication</dt>
        <dd><x-ui.progress class="py-3" :value="$employee->feedback->communication" /></dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Initiative</dt>
        <dd><x-ui.progress class="py-3" :value="$employee->feedback->initiative" /></dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Problem Solving</dt>
        <dd><x-ui.progress class="py-3" :value="$employee->feedback->problem_solving" /></dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Adaptability</dt>
        <dd><x-ui.progress class="py-3" :value="$employee->feedback->adaptability" /></dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Leadership</dt>
        <dd><x-ui.progress class="py-3" :value="$employee->feedback->leadership" /></dd>
      </dl>

      <dl class="col-span-full">
        <dt class="text-sm font-medium text-base-500">Feedback</dt>
        <dd>
          <p>{{ $employee->feedback->description }}</p>
        </dd>
      </dl>
    </div>

    @can('create', $employee->feedback)
      <x-slot:footer class="justify-end">
        <a href="{{ route('employees.feedback.create', $employee) }}">
          <x-ui.button>
            <span>Give Feedback</span>
            <i data-lucide="arrow-up-right" class="size-5"></i>
          </x-ui.button>
        </a>
      </x-slot:footer>
    @endcan
  </x-ui.card>
</x-dashboard-layout>
