@csrf
<div class="grid-cols-2 form">
  <div class="field">
    <x-ui.label for="name" value="Position Name" />
    <x-ui.input id="name" name="name" type="text" value="{{ $position->name ?? old('name') }}" required
      autofocus />
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field">
    <x-ui.label for="level" value="Position Level" />
    <x-ui.select id="level" name="level">
      <option value="">Select level</option>
      @foreach ($levels as $level)
        <option value="{{ $level->value }}" @selected((isset($position) && $position->level === $level) || old('level') == $level->value)>
          {{ $level->label() }}
        </option>
      @endforeach
    </x-ui.select>
    <x-ui.errors :messages="$errors->get('level')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="description" value="Description" />
    <x-ui.textarea id="description" name="description"
      rows="4">{{ $position->description ?? old('description') }}</x-ui.textarea>
    <x-ui.errors :messages="$errors->get('description')" />
  </div>

  <div x-data="multiple()" class="flex flex-col items-start gap-4 col-span-full">
    <div class="w-full field">
      <x-ui.label for="requirements" value="Requirements" />

      <div class="form xl:grid-cols-2" x-show="requirements.length > 0">
        <template x-for="(req, index) in requirements" x-bind:key="index">
          <div class="flex items-center w-full gap-2">
            <x-ui.input x-model="requirements[index]" x-bind:name="'requirements[' + index + ']'"
              placeholder="Enter requirement">
              <x-slot:right>
                <button type="button" x-on:click="remove(index)" class="block text-base-500">
                  <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="fill-current lucide lucide-x">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                  <span class="sr-only">Remove</span>
                </button>
              </x-slot:right>
            </x-ui.input>
          </div>
        </template>
      </div>

      <x-ui.errors :messages="$errors->get('requirements')" />
      <x-ui.errors :messages="$errors->get('requirements.*') ? ['All fields are required'] : []" />
    </div>

    <x-ui.button type="button" x-on:click="append()">
      <i data-lucide="plus" class="size-5"></i>
      <span>Add Requirement</span>
    </x-ui.button>
  </div>
</div>

@push('scripts')
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.data('multiple', () => ({
        requirements: @json(isset($position) ? $position->requirements : old('requirements', [])),
        append() {
          this.requirements.push('');
        },
        remove(index) {
          this.requirements.splice(index, 1);
        }
      }));
    });
  </script>
@endpush
