@extends('layouts.dashboard')
@section('title', 'Schedules')
@section('page-title', 'Manage Barber Schedules')

@section('content')

<div class="grid grid-cols-1 gap-6">
  @forelse($barbers as $barber)
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <div class="px-6 py-4 border-b border-[#f5f5f7] flex items-center justify-between">
      <div>
        <h3 class="text-[0.95rem] font-bold text-[#111111]">{{ $barber->user->name }}</h3>
        <p class="text-[0.75rem] text-[#6e6e73]">{{ $barber->specialty ?? 'Barber' }}</p>
      </div>
    </div>

    {{-- Existing schedules --}}
    @if($barber->schedules->isNotEmpty())
    <div class="divide-y divide-[#f5f5f7]">
      @foreach($barber->schedules->sortBy('day_of_week') as $schedule)
      <div class="px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-6">
          <span class="text-[0.85rem] font-semibold text-[#111111] w-24">{{ $schedule->day_name }}</span>
          @if($schedule->is_day_off)
            <span class="text-[0.75rem] text-[#aeaeb2] italic">Day off</span>
          @else
            <span class="text-[0.82rem] text-[#6e6e73]">{{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }}</span>
          @endif
        </div>
        <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" onsubmit="return confirm('Remove this schedule?')">
          @csrf @method('DELETE')
          <button type="submit" class="text-[0.75rem] font-semibold text-red-500 bg-transparent border-0 cursor-pointer hover:opacity-60">Remove</button>
        </form>
      </div>
      @endforeach
    </div>
    @endif

    {{-- Add schedule form --}}
    <div class="px-6 py-4 bg-[#f5f5f7] border-t border-[#e8e8ed]">
      <p class="text-[0.72rem] font-bold tracking-[0.15em] uppercase text-[#aeaeb2] mb-3">Add Schedule</p>
      <form method="POST" action="{{ route('admin.schedules.store') }}" class="flex items-end gap-3 flex-wrap">
        @csrf
        <input type="hidden" name="barber_id" value="{{ $barber->id }}" />

        <div class="flex flex-col gap-1">
          <label class="text-[0.72rem] font-semibold text-[#6e6e73]">Day</label>
          <select name="day_of_week" required class="px-3 py-2 text-[0.85rem] border border-[#d2d2d7] rounded-lg bg-white outline-none focus:border-[#111111]">
            @foreach(\App\Models\BarberSchedule::$dayNames as $num => $name)
            <option value="{{ $num }}">{{ $name }}</option>
            @endforeach
          </select>
        </div>

        <div class="flex flex-col gap-1">
          <label class="text-[0.72rem] font-semibold text-[#6e6e73]">Start</label>
          <input type="time" name="start_time" value="09:00" class="px-3 py-2 text-[0.85rem] border border-[#d2d2d7] rounded-lg bg-white outline-none focus:border-[#111111]" />
        </div>

        <div class="flex flex-col gap-1">
          <label class="text-[0.72rem] font-semibold text-[#6e6e73]">End</label>
          <input type="time" name="end_time" value="21:00" class="px-3 py-2 text-[0.85rem] border border-[#d2d2d7] rounded-lg bg-white outline-none focus:border-[#111111]" />
        </div>

        <label class="flex items-center gap-1.5 mb-2 cursor-pointer">
          <input type="checkbox" name="is_day_off" class="w-4 h-4" />
          <span class="text-[0.82rem] text-[#6e6e73]">Day off</span>
        </label>

        <button type="submit" class="px-4 py-2 bg-[#111111] text-white text-[0.82rem] font-semibold rounded-lg hover:opacity-80 cursor-pointer border-0">
          Save
        </button>
      </form>
    </div>
  </div>
  @empty
  <div class="text-center py-16 border border-[#d2d2d7] rounded-2xl bg-white">
    <p class="text-[0.9rem] text-[#6e6e73]">No barbers found. <a href="{{ route('admin.barbers.create') }}" class="font-semibold text-[#111111] underline">Add a barber first.</a></p>
  </div>
  @endforelse
</div>
@endsection
