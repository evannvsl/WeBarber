@extends('layouts.app')
@section('title', 'WeBarber — Services')

@push('styles')
<style>
  html { scroll-behavior: smooth; }
  .banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(-45deg,rgba(255,255,255,.015) 0px,rgba(255,255,255,.015) 1px,transparent 1px,transparent 10px);
    pointer-events: none;
  }
  .policy-list li::before { content: '—'; position: absolute; left: 0; color: #b8a060; font-weight: 700; }
</style>
@endpush

@section('content')

{{-- Banner --}}
<section class="banner relative bg-[#0a0a0a] py-20 px-8 text-center overflow-hidden max-sm:py-14">
  <p class="text-[0.7rem] font-bold tracking-[0.3em] uppercase text-[#b8a060] mb-4">Our Services</p>
  <h2 class="text-[clamp(2rem,5vw,3.4rem)] font-extrabold tracking-[-1px] text-white leading-none mb-4">Grooming, Redefined.</h2>
  <p class="text-[0.7rem] font-light italic text-white/45 max-w-[440px] mx-auto">Every cut tells a story. We make sure yours is worth telling.</p>
</section>

<main class="max-w-[960px] mx-auto px-6 pb-24 max-sm:px-4">

  {{-- Group services by category (based on duration as proxy) --}}
  @php
    $haircut   = $services->where('duration_minutes', '<=', 60)->where('duration_minutes', '>=', 30);
    $beard     = $services->where('duration_minutes', '<', 30);
    $treatment = $services->where('duration_minutes', '>', 60);
    $all       = $services;
  @endphp

  <section class="mt-14">
    <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-1">All Services</p>
    <h3 class="text-[1.55rem] font-extrabold tracking-[-0.5px] text-[#0a0a0a] mb-6 pb-4 border-b border-[#d2d2d7]">What We Offer</h3>

    @if($services->isEmpty())
      <p class="text-[#6e6e73] text-[0.9rem]">No services available at the moment.</p>
    @else
      <div class="grid grid-cols-[repeat(auto-fill,minmax(260px,1fr))] gap-4 max-sm:grid-cols-1">
        @foreach($services as $service)
        <div class="relative {{ $loop->last && $services->count() % 3 === 0 ? 'bg-[#0a0a0a] border-[#0a0a0a]' : 'bg-white border-[#d2d2d7] hover:border-[#c2c2c7]' }} border rounded-2xl px-6 py-5 flex flex-col gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09),0_12px_32px_rgba(0,0,0,0.07)]">
          <div class="flex justify-between items-baseline gap-2">
            <span class="text-[1rem] font-bold tracking-tight {{ $loop->last && $services->count() % 3 === 0 ? 'text-white' : 'text-[#0a0a0a]' }}">{{ $service->name }}</span>
            <span class="text-[0.95rem] font-bold whitespace-nowrap tracking-tight {{ $loop->last && $services->count() % 3 === 0 ? 'text-white' : 'text-[#0a0a0a]' }}">{{ $service->price_formatted }}</span>
          </div>
          <p class="text-[0.83rem] leading-relaxed flex-1 {{ $loop->last && $services->count() % 3 === 0 ? 'text-white/55' : 'text-[#6e6e73]' }}">{{ $service->description ?? 'Professional grooming service.' }}</p>
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase mt-1 {{ $loop->last && $services->count() % 3 === 0 ? 'text-white' : 'text-[#aeaeb2]' }}">± {{ $service->duration_minutes }} min</span>
        </div>
        @endforeach
      </div>
    @endif
  </section>

  {{-- Operating Hours --}}
  <section class="mt-14">
    <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-1">Schedule</p>
    <h3 class="text-[1.55rem] font-extrabold tracking-[-0.5px] text-[#0a0a0a] mb-6 pb-4 border-b border-[#d2d2d7]">Operating Hours</h3>
    <div class="overflow-hidden rounded-2xl border border-[#d2d2d7] shadow-[0_2px_8px_rgba(0,0,0,0.05)] bg-white">
      <table class="w-full border-collapse text-[0.88rem]">
        <thead class="bg-[#0a0a0a]">
          <tr>
            <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Day</th>
            <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Open</th>
            <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Close</th>
            <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b border-[#f5f5f7] hover:bg-[#f5f5f7]">
            <td class="px-5 py-3.5 text-[#3a3a3c]">Monday – Friday</td>
            <td class="px-5 py-3.5 text-[#3a3a3c]">09.00 AM</td>
            <td class="px-5 py-3.5 text-[#3a3a3c]">21.00 PM</td>
            <td class="px-5 py-3.5"><span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full bg-[#f0faf4] text-[#1a7a40] border border-[#b6e8cc]">Open</span></td>
          </tr>
          <tr class="border-b border-[#f5f5f7] hover:bg-[#f5f5f7]">
            <td class="px-5 py-3.5 text-[#3a3a3c]">Saturday</td>
            <td class="px-5 py-3.5 text-[#3a3a3c]">08.00 AM</td>
            <td class="px-5 py-3.5 text-[#3a3a3c]">22.00 PM</td>
            <td class="px-5 py-3.5"><span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full bg-[#f0faf4] text-[#1a7a40] border border-[#b6e8cc]">Open</span></td>
          </tr>
          <tr class="border-b border-[#f5f5f7] hover:bg-[#f5f5f7]">
            <td class="px-5 py-3.5 text-[#3a3a3c]">Sunday</td>
            <td class="px-5 py-3.5 text-[#3a3a3c]">09.00 AM</td>
            <td class="px-5 py-3.5 text-[#3a3a3c]">20.00 PM</td>
            <td class="px-5 py-3.5"><span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full bg-[#f0faf4] text-[#1a7a40] border border-[#b6e8cc]">Open</span></td>
          </tr>
          <tr class="hover:bg-[#f5f5f7]">
            <td class="px-5 py-3.5 text-[#3a3a3c]">National Holidays</td>
            <td class="px-5 py-3.5 text-[#3a3a3c]">—</td>
            <td class="px-5 py-3.5 text-[#3a3a3c]">—</td>
            <td class="px-5 py-3.5"><span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full bg-[#faf0f0] text-[#8a2020] border border-[#f0c0c0]">Closed</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  {{-- Terms --}}
  <section class="mt-14">
    <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-1">Information</p>
    <h3 class="text-[1.55rem] font-extrabold tracking-[-0.5px] text-[#0a0a0a] mb-6 pb-4 border-b border-[#d2d2d7]">Terms &amp; Conditions</h3>
    <ul class="policy-list list-none p-0 flex flex-col">
      <li class="relative text-[0.9rem] text-[#3a3a3c] py-4 pl-6 border-b border-[#e8e8ed] leading-relaxed">Walk-in available, but reservations are recommended to avoid waiting.</li>
      <li class="relative text-[0.9rem] text-[#3a3a3c] py-4 pl-6 border-b border-[#e8e8ed] leading-relaxed">Cancellation of reservations should be done at least 1 hour before the scheduled time.</li>
      <li class="relative text-[0.9rem] text-[#3a3a3c] py-4 pl-6 border-b border-[#e8e8ed] leading-relaxed">Prices may change at any time, please confirm at the time of reservation.</li>
      <li class="relative text-[0.9rem] text-[#3a3a3c] py-4 pl-6 border-b border-[#e8e8ed] leading-relaxed">We use premium care products free from parabens.</li>
      <li class="relative text-[0.9rem] text-[#3a3a3c] py-4 pl-6 leading-relaxed">Customer satisfaction is our priority — not satisfied? We'll fix it at no extra cost.</li>
    </ul>
  </section>

</main>
@endsection
