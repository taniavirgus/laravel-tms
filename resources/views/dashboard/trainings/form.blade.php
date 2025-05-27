<div class="grid grid-cols-1 gap-4 md:grid-cols-2 form">
  <div class="field col-span-full">
    <x-ui.label for="name" value="Title" />
    <x-ui.input id="name" name="name" type="text" value="{{ old('name', $training->name) }}" required
      autofocus />
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="description" value="Description" />
    <x-ui.textarea id="description" name="description"
      rows="4">{{ old('description', $training->description) }}</x-ui.textarea>
    <x-ui.errors :messages="$errors->get('description')" />
  </div>

  <div class="field">
    <x-ui.label for="type" value="Type" />
    <x-ui.select id="type" name="type" class="w-full" required>
      <option value="">Select Type</option>
      @foreach ($types as $type)
        <option value="{{ $type->value }}" @selected(old('type', $training->type?->value) == $type->value)>
          {{ $type->label() }}
        </option>
      @endforeach
    </x-ui.select>
    <x-ui.errors :messages="$errors->get('type')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="evaluation_id" value="Evaluation" />
    <div class="flex items-center gap-2">
      <x-ui.select id="evaluation_id" name="evaluation_id" class="w-full">
        <option value="">Select evaluation</option>
        @foreach ($evaluations as $evaluation)
          <option value="{{ $evaluation->id }}" @selected(old('evaluation_id', $training->evaluation_id) == $evaluation->id)>
            {{ $evaluation->name }}
          </option>
        @endforeach
      </x-ui.select>
      <a href="{{ route('evaluations.create') }}">
        <x-ui.button size="icon" type="button" tooltip="Add evaluation">
          <i data-lucide="plus" class="size-5"></i>
        </x-ui.button>
      </a>
    </div>
    <x-ui.errors :messages="$errors->get('evaluation_id')" />
  </div>

  <div class="field">
    <x-ui.label for="start_date" value="Start Date" />
    <x-ui.input id="start_date" name="start_date" type="date"
      value="{{ old('start_date', $training->start_date?->format('Y-m-d')) }}" required />
    <x-ui.errors :messages="$errors->get('start_date')" />
  </div>

  <div class="field">
    <x-ui.label for="end_date" value="End Date" />
    <x-ui.input id="end_date" name="end_date" type="date"
      value="{{ old('end_date', $training->end_date?->format('Y-m-d')) }}" required />
    <x-ui.errors :messages="$errors->get('end_date')" />
  </div>

  <div class="field">
    <x-ui.label for="duration" value="Duration (in hours)" />
    <x-ui.input id="duration" name="duration" type="number" value="{{ old('duration', $training->duration) }}"
      min="1" required />
    <x-ui.errors :messages="$errors->get('duration')" />
  </div>

  <div class="field">
    <x-ui.label for="capacity" value="Capacity" />
    <x-ui.input id="capacity" name="capacity" type="number" value="{{ old('capacity', $training->capacity) }}"
      min="1" required />
    <x-ui.errors :messages="$errors->get('capacity')" />
  </div>

  <div x-data="departments()" class="flex flex-col items-start gap-4 col-span-full">
    <div class="w-full field">
      <x-ui.label for="assignment" value="Department Assignment" />
      <x-ui.select id="assignment" name="assignment" class="w-full" required x-model="assignment">
        <option value="">Select Assignment Type</option>
        @foreach ($assignments as $assignment)
          <option value="{{ $assignment->value }}" @selected(old('assignment', $training->assignment?->value) == $assignment->value)>
            {{ $assignment->label() }}
          </option>
        @endforeach
      </x-ui.select>
      <x-ui.errors :messages="$errors->get('assignment')" />
    </div>

    <div class="w-full form xl:grid-cols-2" x-show="assignment === 'closed'" x-cloak>
      <template x-for="(dept, index) in selected" :key="index">
        <div class="flex items-center w-full gap-2">
          <x-ui.select x-model="selected[index]" :name="'department_ids[]'" class="w-full">
            <option value="">Select Department</option>
            @foreach ($departments as $department)
              <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
          </x-ui.select>
          <button type="button" @click="remove(index)" class="text-base-500">
            <i data-lucide="x" class="size-5"></i>
            <span class="sr-only">Remove</span>
          </button>
        </div>
      </template>

      <x-ui.errors :messages="$errors->get('department_ids')" />
      <x-ui.errors :messages="$errors->get('department_ids.*')" />
    </div>

    <x-ui.button type="button" @click="append()" x-show="assignment === 'closed'" x-cloak>
      <i data-lucide="plus" class="size-5"></i>
      <span>Add Department</span>
    </x-ui.button>
  </div>
</div>

@push('scripts')
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('departments', () => ({
        assignment: @json(old('assignment', $training->assignment?->value)),
        selected: @json(old('department_ids', $training->departments->pluck('id')->toArray() ?? [])),
        append() {
          this.selected.push('');
        },
        remove(index) {
          this.selected.splice(index, 1);
        }
      }));
    });
  </script>
@endpush
