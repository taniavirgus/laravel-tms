<div class="grid grid-cols-1 gap-4 md:grid-cols-2 form">
  <div class="field col-span-full">
    <x-ui.label for="name" value="Title" />
    <x-ui.input id="name" name="name" type="text" value="{{ old('name', $talent->name) }}" required autofocus />
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="description" value="Description" />
    <x-ui.textarea id="description" name="description"
      rows="4">{{ old('description', $talent->description) }}</x-ui.textarea>
    <x-ui.errors :messages="$errors->get('description')" />
  </div>

  <div class="field">
    <x-ui.label for="start_date" value="Start Date" />
    <x-ui.input id="start_date" name="start_date" type="date"
      value="{{ old('start_date', $talent->start_date?->format('Y-m-d')) }}" required />
    <x-ui.errors :messages="$errors->get('start_date')" />
  </div>

  <div class="field">
    <x-ui.label for="end_date" value="End Date" />
    <x-ui.input id="end_date" name="end_date" type="date"
      value="{{ old('end_date', $talent->end_date?->format('Y-m-d')) }}" required />
    <x-ui.errors :messages="$errors->get('end_date')" />
  </div>

  <div class="field">
    <x-ui.label for="duration" value="Duration (in hours)" />
    <x-ui.input id="duration" name="duration" type="number" value="{{ old('duration', $talent->duration) }}"
      min="1" required />
    <x-ui.errors :messages="$errors->get('duration')" />
  </div>

  @isset($segment)
    <div class="field">
      <x-ui.label for="segment" value="Talent Segment" />
      <x-ui.input type="text" value="{{ $segment->label() }}" required readonly />
      <x-ui.input id="segment" name="segment" type="text" value="{{ $segment->value }}" class="hidden" readonly />
      <x-ui.errors :messages="$errors->get('segment')" />
    </div>
  @else
    <div class="field">
      <x-ui.label for="segment" value="Talent Segment" />
      <x-ui.select id="segment" name="segment" class="w-full" required x-model="segment">
        <option value="">Select Segment</option>
        @foreach ($segments as $segment)
          <option value="{{ $segment->value }}" @selected(old('segment', $talent->segment?->value) == $segment->value)>
            {{ $segment->label() }}
          </option>
        @endforeach
      </x-ui.select>
      <x-ui.errors :messages="$errors->get('segment')" />
    </div>
  @endisset
</div>
