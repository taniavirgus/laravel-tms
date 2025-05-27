<div class="grid-cols-1 form">
  <div class="field">
    <x-ui.label for="year" value="Year" />
    <x-ui.input id="year" name="year" type="number" value="{{ old('year', $period->year) }}" required autofocus />
    <x-ui.errors :messages="$errors->get('year')" />
  </div>

  <div class="field">
    <x-ui.label for="semester" value="Semester" />
    <x-ui.select id="semester" name="semester" required>
      <option value="">Select semester</option>
      @foreach ($semesters as $semester)
        <option value="{{ $semester->value }}" @selected(old('semester', $period->semester?->value) == $semester->value)>
          {{ $semester->label() }}
        </option>
      @endforeach
    </x-ui.select>
    <x-ui.errors :messages="$errors->get('semester')" />
  </div>
</div>
