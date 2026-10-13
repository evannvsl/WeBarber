@extends('layouts.app')
@section('title', 'WeBarber — Our Barbers')

@section('content')

<section class="relative bg-[#0a0a0a] py-20 px-8 text-center overflow-hidden">
  <p class="text-[0.7rem] font-bold tracking-[0.3em] uppercase text-[#b8a060] mb-4">Meet the Team</p>
  <h2 class="text-[clamp(2rem,5vw,3.4rem)] font-extrabold tracking-[-1px] text-white leading-none mb-4">Our Barbers.</h2>
  <p class="text-[0.7rem] font-light italic text-white/45 max-w-[440px] mx-auto">Every great cut starts with a skilled hand and a trained eye.</p>
</section>

<main class="max-w-[960px] mx-auto px-6 pb-24 pt-14">

  @if($barbers->isEmpty())
    <div class="text-center py-20">
      <p class="text-[1rem] text-[#6e6e73]">No barbers available at the moment.</p>
    </div>
  @else
  <div class="grid grid-cols-2 gap-6 max-sm:grid-cols-1">
    @foreach($barbers as $barber)
    <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)]">
      <div class="px-7 py-7 flex flex-col gap-4">
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 rounded-full bg-[#f5f5f7] border border-[#d2d2d7] flex items-center justify-center text-[1.3rem] font-extrabold text-[#3a3a3c] shrink-0">
            {{ strtoupper(substr($barber->user->name, 0, 1)) }}
          </div>
          <div>
            <h3 class="text-[1.05rem] font-bold text-[#111111] tracking-tight">{{ $barber->user->name }}</h3>
            <p class="text-[0.75rem] font-semibold text-[#b8a060] tracking-[0.04em]">{{ $barber->specialty ?? 'Professional Barber' }}</p>
          </div>
        </div>

        @if($barber->bio)
        <p class="text-[0.85rem] text-[#6e6e73] leading-relaxed">{{ $barber->bio }}</p>
        @endif

        {{-- Schedule --}}
        @if($barber->schedules->isNotEmpty())
        <div class="border-t border-[#f5f5f7] pt-4">
          <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-2">Working Hours</p>
          <div class="flex flex-col gap-1">
            @foreach($barber->schedules->where('is_day_off', false)->sortBy('day_of_week') as $schedule)
            <div class="flex justify-between text-[0.8rem]">
              <span class="text-[#3a3a3c]">{{ $schedule->day_name }}</span>
              <span class="text-[#6e6e73]">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        <a href="{{ route('customer.booking') }}" class="mt-1 inline-flex items-center gap-1.5 text-[0.82rem] font-semibold text-[#111111] no-underline border-b border-[#111111] pb-px self-start transition-opacity hover:opacity-55">
          Book with {{ explode(' ', $barber->user->name)[0] }} →
        </a>
      </div>
    </div>
    @endforeach
  </div>
  @endif

</main>
@endsection
