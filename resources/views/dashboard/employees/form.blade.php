<div class="grid grid-cols-1 gap-4 md:grid-cols-2 form">
  <div class="field">
    <x-ui.label for="name" value="Employee Name" /> <x-ui.input id="name" name="name" type="text"
      value="{{ old('name', $employee->name) }}" required autofocus />
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field">
    <x-ui.label for="email" value="Email Address" /> <x-ui.input id="email" name="email" type="email"
      value="{{ old('email', $employee->email) }}" required />
    <x-ui.errors :messages="$errors->get('email')" />
  </div>

  <div class="field">
    <x-ui.label for="phone" value="Phone Number" /> <x-ui.input id="phone" name="phone" type="text"
      value="{{ old('phone', $employee->phone) }}" required />
    <x-ui.errors :messages="$errors->get('phone')" />
  </div>

  <div class="field">
    <x-ui.label for="birthdate" value="Birthdate" /> <x-ui.input id="birthdate" name="birthdate" type="date"
      value="{{ old('birthdate', $employee->birthdate?->format('Y-m-d')) }}" required />
    <x-ui.errors :messages="$errors->get('birthdate')" />
  </div>

  <div class="field">
    <x-ui.label for="gender" value="Gender" />
    <x-ui.select id="gender" name="gender">
      <option value="">Select Gender</option>
      @foreach ($genders as $gender)
        <option value="{{ $gender->value }}" @selected(old('gender', $employee->gender?->value) == $gender->value)>
          {{ $gender->label() }}
        </option>
      @endforeach
    </x-ui.select>
    <x-ui.errors :messages="$errors->get('gender')" />
  </div>

  <div class="field">
    <x-ui.label for="religion" value="Religion" />
    <x-ui.select id="religion" name="religion">
      <option value="">Select Religion</option>
      @foreach ($religions as $religion)
        <option value="{{ $religion->value }}" @selected(old('religion', $employee->religion?->value) == $religion->value)>
          {{ $religion->label() }}
        </option>
      @endforeach
    </x-ui.select>
    <x-ui.errors :messages="$errors->get('religion')" />
  </div>

  <div class="field">
    <x-ui.label for="department_id" value="Department" />
    <div class="flex items-center gap-2">
      <x-ui.select id="department_id" name="department_id" class="w-full">
        <option value="">Select Department</option>
        @foreach ($departments as $department)
          <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id) == $department->id)>
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
    <x-ui.label for="position_id" value="Position" />
    <div class="flex items-center gap-2">
      <x-ui.select id="position_id" name="position_id" class="w-full">
        <option value="">Select Position</option>
        @foreach ($positions as $position)
          <option value="{{ $position->id }}" @selected(old('position_id', $employee->position_id) == $position->id)>
            {{ $position->name }}
          </option>
        @endforeach
      </x-ui.select>
      <a href="{{ route('positions.create') }}">
        <x-ui.button size="icon" type="button" tooltip="Add Position">
          <i data-lucide="plus" class="size-5"></i>
        </x-ui.button>
      </a>
    </div>
    <x-ui.errors :messages="$errors->get('position_id')" />
  </div>

  <div class="field">
    <x-ui.label for="status" value="Status" />
    <x-ui.select id="status" name="status">
      @foreach ($statuses as $status)
        <option value="{{ $status->value }}" @selected(old('status', $employee->value) === $status->value)>
          {{ $status->label() }}
        </option>
      @endforeach
    </x-ui.select>
    <x-ui.errors :messages="$errors->get('status')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="address" value="Address" /> <x-ui.textarea id="address" name="address"
      rows="3">{{ old('address', $employee->address) }}</x-ui.textarea>
    <x-ui.errors :messages="$errors->get('address')" />
  </div>
</div>
