@php
  use App\Models\Period;

  $periods = Period::all();
  $current = session('period_id');
@endphp

<form action="{{ route('periods.switch') }}" method="POST" class="w-40">
  @csrf
  <x-ui.select name="period_id" onchange="this.form.submit()">
    @foreach ($periods as $period)
      <option value="{{ $period->id }}" @selected($current == $period->id)>
        {{ $period->semester->label() }} - {{ $period->year }}
      </option>
    @endforeach
  </x-ui.select>
</form>
