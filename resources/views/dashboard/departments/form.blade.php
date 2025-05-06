@csrf
<div class="grid-cols-1 form">
  <div class="field">
    <x-ui.label for="name" value="Department Name" />
    <x-ui.input id="name" name="name" type="text" class="block w-full mt-1" :value="$department->name ?? old('name')" required
      autofocus />
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="description" value="Description" />
    <x-ui.textarea id="description" name="description" class="block w-full mt-1"
      rows="4">{{ $department->description ?? old('description') }}</x-ui.textarea>
    <x-ui.errors :messages="$errors->get('description')" />
  </div>
</div>
