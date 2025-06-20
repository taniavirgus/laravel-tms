<div class="grid grid-cols-1 gap-4 md:grid-cols-2 form">
  <div class="field">
    <x-ui.label for="teamwork" value="Teamwork" /> <x-ui.range id="teamwork" name="teamwork" type="range"
      value="{{ old('teamwork', $feedback->teamwork) }}" autofocus />
    <x-ui.errors :messages="$errors->get('teamwork')" />
  </div>

  <div class="field">
    <x-ui.label for="communication" value="Communication" /> <x-ui.range id="communication" name="communication"
      type="range" value="{{ old('communication', $feedback->communication) }}" />
    <x-ui.errors :messages="$errors->get('communication')" />
  </div>

  <div class="field">
    <x-ui.label for="initiative" value="Initiative" /> <x-ui.range id="initiative" name="initiative" type="range"
      value="{{ old('initiative', $feedback->initiative) }}" />
    <x-ui.errors :messages="$errors->get('initiative')" />
  </div>

  <div class="field">
    <x-ui.label for="problem_solving" value="Problem Solving" /> <x-ui.range id="problem_solving" name="problem_solving"
      type="range" value="{{ old('problem_solving', $feedback->problem_solving) }}" />
    <x-ui.errors :messages="$errors->get('problem_solving')" />
  </div>

  <div class="field">
    <x-ui.label for="adaptability" value="Adaptability" /> <x-ui.range id="adaptability" name="adaptability"
      type="range" value="{{ old('adaptability', $feedback->adaptability) }}" />
    <x-ui.errors :messages="$errors->get('adaptability')" />
  </div>

  <div class="field">
    <x-ui.label for="talent" value="Talent" /> <x-ui.range id="talent" name="talent" type="range"
      value="{{ old('talent', $feedback->talent) }}" />
    <x-ui.errors :messages="$errors->get('talent')" />
  </div>

  <div class="field col-span-full">
    <x-ui.label for="description" value="Feedback" /> <x-ui.textarea id="description" name="description"
      rows="4">{{ old('description', $feedback->description) }}</x-ui.textarea>
    <x-ui.errors :messages="$errors->get('description')" />
  </div>
</div>
