<div class="grid-cols-1 form">
  <div class="field">
    <x-ui.label for="name" value="Topic Name" /> <x-ui.input id="name" name="name" type="text"
      value="{{ old('name', $topic->name) }}" required autofocus />
    <x-ui.errors :messages="$errors->get('name')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="description" value="Description" /> <x-ui.textarea id="description" name="description"
      rows="4">{{ old('description', $topic->description) }}</x-ui.textarea>
    <x-ui.errors :messages="$errors->get('description')" />
  </div>
</div>
