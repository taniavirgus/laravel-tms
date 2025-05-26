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

  <x-ui.card>
    <x-slot:header>
      <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
      <h5>Employee Matrix</h5>
    </x-slot:header>

    <div class="grid grid-cols-2 gap-6">
      <dl>
        <dt class="text-sm font-medium text-base-500">Training</dt>
        <dd class="font-semibold">{{ $matrix->training_count }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Evaluation</dt>
        <dd class="font-semibold">{{ $matrix->evaluation_count }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Feedback</dt>
        <dd class="font-semibold">{{ number_format($matrix->feedback_score, 1) }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Potential</dt>
        <dd class="font-semibold">{{ number_format($matrix->potential_score, 1) }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Performance</dt>
        <dd class="font-semibold">{{ number_format($matrix->performance_score, 1) }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Average</dt>
        <dd class="font-semibold">{{ number_format($matrix->average_score, 1) }}</dd>
      </dl>

      <dl>
        <dt class="text-sm font-medium text-base-500">Segment</dt>
        {{-- <dd><x-ui.badge :value="$matrix->segment" /></dd> --}}
      </dl>
    </div>
  </x-ui.card>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="chart-pie" class="size-5 text-primary-500"></i>
      <h4>Assigned Evaluations</h4>
    </x-slot:title>

    <x-slot:head>
      <th>No</th>
      <th>Name</th>
      <th>Topic</th>
      <th>Department</th>
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
      <x-slot:form action="{{ route('employees.score', $employee) }}" method="POST" id="form-score">
        @csrf
        @method('PATCH')
      </x-slot:form>

      <x-slot:footer class="justify-end">
        <x-ui.button type="submit" form="form-score">
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

    @can('create', $employee->feedback)
      <form action="{{ route('employees.feedback.store', $employee) }}" method="POST" id="form-feedback">
        @csrf

        <div class="form xl:grid-cols-2">
          <div class="field">
            <x-ui.label for="teamwork" value="Teamwork" />
            <x-ui.range :tooltip="false" id="teamwork" name="teamwork" type="range" :value="old('teamwork', $employee->feedback->teamwork)" />
            <x-ui.errors :messages="$errors->get('teamwork')" />
          </div>

          <div class="field">
            <x-ui.label for="communication" value="Communication" />
            <x-ui.range :tooltip="false" id="communication" name="communication" type="range" :value="old('communication', $employee->feedback->communication)" />
            <x-ui.errors :messages="$errors->get('communication')" />
          </div>

          <div class="field">
            <x-ui.label for="initiative" value="Initiative" />
            <x-ui.range :tooltip="false" id="initiative" name="initiative" type="range" :value="old('initiative', $employee->feedback->initiative)" />
            <x-ui.errors :messages="$errors->get('initiative')" />
          </div>

          <div class="field">
            <x-ui.label for="problem_solving" value="Problem Solving" />
            <x-ui.range :tooltip="false" id="problem_solving" name="problem_solving" type="range"
              :value="old('problem_solving', $employee->feedback->problem_solving)" />
            <x-ui.errors :messages="$errors->get('problem_solving')" />
          </div>

          <div class="field">
            <x-ui.label for="adaptability" value="Adaptability" />
            <x-ui.range :tooltip="false" id="adaptability" name="adaptability" type="range" :value="old('adaptability', $employee->feedback->adaptability)" />
            <x-ui.errors :messages="$errors->get('adaptability')" />
          </div>

          <div class="field">
            <x-ui.label for="leadership" value="Leadership" />
            <x-ui.range :tooltip="false" id="leadership" name="leadership" type="range" :value="old('leadership', $employee->feedback->leadership)" />
            <x-ui.errors :messages="$errors->get('leadership')" />
          </div>

          <div class="field col-span-full">
            <x-ui.label for="description" value="Feedback" />
            <x-ui.textarea id="description" name="description"
              rows="4">{{ old('description', $employee->feedback->description) }}</x-ui.textarea>
            <x-ui.errors :messages="$errors->get('description')" />
          </div>
        </div>
      </form>
    @else
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
    @endcan

    @can('create', $employee->feedback)
      <x-slot:footer class="justify-end">
        <x-ui.button type="submit" form="form-feedback">
          <span>Update</span>
          <i data-lucide="arrow-up-right" class="size-5"></i>
        </x-ui.button>
      </x-slot:footer>
    @endcan
  </x-ui.card>

  <x-ui.table>
    <x-slot:title>
      <i data-lucide="file-text" class="size-5 text-primary-500"></i>
      <h4>Assigned Trainings</h4>
    </x-slot:title>

    <x-slot:head>
      <th>No</th>
      <th>Title</th>
      <th>Department</th>
      <th>Type</th>
      <th>Date</th>
      <th>Status</th>
      <th>Actions</th>
    </x-slot:head>

    <x-slot:body>
      @forelse ($trainings as $training)
        <tr>
          <td class="w-10">{{ $training->id }}</td>
          <td>{{ $training->name }}</td>
          <td>{{ $training->department->name }}</td>
          <td><x-ui.badge :value="$training->type" /></td>
          <td>
            <div class="flex items-center gap-2">
              <span class="whitespace-nowrap">{{ $training->start_date->format('d M Y') }}</span>
              <hr class="w-10 bg-base-500" />
              <span class="whitespace-nowrap">{{ $training->end_date->format('d M Y') }}</span>
            </div>
          </td>
          <td><x-ui.badge :value="$training->status" /></td>
          <td>
            <div class="flex items-center gap-4">
              <a href="{{ route('trainings.show', $training) }}" class="text-primary-500">
                View
              </a>
            </div>
          </td>
        </tr>
      @empty
        <x-ui.empty colspan="8" message="No trainings assigned to this employee" />
      @endforelse
    </x-slot:body>
  </x-ui.table>
</x-dashboard-layout>
