@csrf
<div class="grid grid-cols-1 gap-4 md:grid-cols-2 form">
  <div class="field col-span-full">
    <x-ui.label for="name" value="Evaluation Name" />
    <x-ui.input id="name" name="name" type="text" value="{{ $evaluation->name ?? old('name') }}" required
      autofocus />
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="description" value="Description" />
    <x-ui.textarea id="description" name="description"
      rows="4">{{ $evaluation->description ?? old('description') }}</x-ui.textarea>
    <x-ui.errors :messages="$errors->get('description')" />
  </div>

  <div class="field">
    <x-ui.label for="department_id" value="Department" />
    <div class="flex items-center gap-2">
      <x-ui.select id="department_id" name="department_id" class="w-full" required>
        <option value="">Select Department</option>
        @foreach ($departments as $department)
          <option value="{{ $department->id }}" @selected((isset($evaluation) && $evaluation->department_id == $department->id) || old('department_id') == $department->id)>
            {{ $department->name }}
          </option>
        @endforeach
      </x-ui.select>
      <a href="{{ route('departments.create') }}">
        <x-ui.button size="icon" type="button" tooltip="Add Department">
          <i data-lucide="plus" class="size-5"></i>
        </x-ui.button>
      </a>
    </div>
    <x-ui.errors :messages="$errors->get('department_id')" />
  </div>

  <div class="field">
    <x-ui.label for="topic_id" value="Topic" />
    <div class="flex items-center gap-2">
      <x-ui.select id="topic_id" name="topic_id" class="w-full" required>
        <option value="">Select Topic</option>
        @foreach ($topics as $topic)
          <option value="{{ $topic->id }}" @selected((isset($evaluation) && $evaluation->topic_id == $topic->id) || old('topic_id') == $topic->id)>
            {{ $topic->name }}
          </option>
        @endforeach
      </x-ui.select>
      <a href="{{ route('topics.create') }}">
        <x-ui.button size="icon" type="button" tooltip="Add Topic">
          <i data-lucide="plus" class="size-5"></i>
        </x-ui.button>
      </a>
    </div>
    <x-ui.errors :messages="$errors->get('topic_id')" />
  </div>

  <div class="grid gap-4 xl:grid-cols-3 col-span-full">
    <div class="field">
      <x-ui.label for="point" value="Point" />
      <x-ui.input id="point" name="point" type="number" min="0" step="1"
        value="{{ $evaluation->point ?? (old('point') ?? 0) }}" required />
      <x-ui.errors :messages="$errors->get('point')" />
    </div>

    <div class="field">
      <x-ui.label for="target" value="Target" />
      <x-ui.input id="target" name="target" type="number" min="0" step="1"
        value="{{ $evaluation->target ?? (old('target') ?? 0) }}" required />
      <x-ui.errors :messages="$errors->get('target')" />
    </div>

    <div class="field">
      <x-ui.label for="weight" value="Weight (%)" />
      <x-ui.input id="weight" name="weight" type="number" min="0" max="100" step="1"
        value="{{ $evaluation->weight ?? (old('weight') ?? 0) }}" required />
      <x-ui.errors :messages="$errors->get('weight')" />
    </div>
  </div>
</div>
