@extends('layouts.dashboard')
@section('title', 'My Schedule')
@section('page-title', 'My Schedule')

@section('content')
<div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
  <div class="px-6 py-4 border-b border-[#f5f5f7]">
    <h3 class="text-[0.95rem] font-bold text-[#111111]">{{ $barber->user?->name }}'s Schedule</h3>
    @if($barber->specialty)
    <p class="text-[0.75rem] text-[#6e6e73] mt-0.5">{{ $barber->specialty }}</p>
    @endif
  </div>

  @if($schedules->isNotEmpty())
  <div class="divide-y divide-[#f5f5f7]">
    @foreach($schedules as $schedule)
    <div class="px-6 py-4 flex items-center justify-between">
      <div class="flex items-center gap-6">
        <span class="text-[0.88rem] font-semibold text-[#111111] w-28">{{ $schedule->day_name }}</span>
        @if($schedule->is_day_off)
          <span class="text-[0.75rem] text-[#aeaeb2] italic">Day off</span>
        @else
          <span class="text-[0.82rem] text-[#6e6e73]">{{ substr($schedule->start_time, 0, 5) }} – {{ substr($schedule->end_time, 0, 5) }}</span>
        @endif
      </div>
      @if($schedule->is_day_off)
        <span class="inline-block text-[0.68rem] font-bold uppercase px-2 py-0.5 rounded-full border bg-red-50 text-red-700 border-red-200">Off</span>
      @else
        <span class="inline-block text-[0.68rem] font-bold uppercase px-2 py-0.5 rounded-full border bg-green-50 text-green-700 border-green-200">Active</span>
      @endif
    </div>
    @endforeach
  </div>
  @else
  <div class="px-6 py-10 text-center">
    <p class="text-[0.88rem] text-[#6e6e73]">No schedule set yet. Contact admin to set up your schedule.</p>
  </div>
  @endif
</div>
@endsection
