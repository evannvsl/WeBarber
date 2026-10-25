@extends('layouts.app')
@section('title', 'WeBarber | Menu')

@push('styles')
<style>
  html { scroll-behavior: smooth; }
  body { -webkit-font-smoothing: antialiased; }
  .banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(
      -45deg,
      rgba(255,255,255,0.015) 0px,
      rgba(255,255,255,0.015) 1px,
      transparent 1px,
      transparent 10px
    );
    pointer-events: none;
  }
  .policy-list li::before {
    content: '—';
    position: absolute;
    left: 0;
    color: #b8a060;
    font-weight: 700;
  }
  /* Service card clickable */
  .svc-card { text-decoration: none; color: inherit; display: flex; flex-direction: column; }
  .svc-card .book-hint { opacity: 0; transition: opacity 0.2s; }
  .svc-card:hover .book-hint { opacity: 1; }
</style>
@endpush

@section('content')

{{-- Banner --}}
<section class="banner relative bg-[#0a0a0a] py-20 px-8 text-center overflow-hidden max-sm:py-14 max-sm:px-5">
  <p class="text-[0.7rem] font-bold tracking-[0.3em] uppercase text-[#b8a060] mb-4">Our Services</p>
  <h2 class="text-[clamp(2rem,5vw,3.4rem)] font-extrabold tracking-[-1px] text-white leading-none mb-4">Grooming, Redefined.</h2>
  <p class="text-[0.7rem] font-light italic text-white/45 max-w-[440px] mx-auto">Every cut tells a story. We make sure yours is worth telling.</p>
</section>

@php
  /* Destination saat card diklik */
  $bookUrl = auth()->check() ? route('customer.booking') : route('barbers');
@endphp

<main class="max-w-[960px] mx-auto px-6 pb-24 max-sm:px-4">

  {{-- ── Haircut & Styling ── --}}
  <section class="mt-14 max-sm:mt-10">
    <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-1">Services</p>
    <h3 class="text-[1.55rem] font-extrabold tracking-[-0.5px] text-[#0a0a0a] mb-6 pb-4 border-b border-[#d2d2d7]">Haircut &amp; Styling</h3>
    <div class="grid grid-cols-[repeat(auto-fill,minmax(260px,1fr))] gap-4 max-sm:grid-cols-1">

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Textured Fringe</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 75.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Long bangs with textured fringe styling. Wet-look curtain &amp; layered flow variations available.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 45 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Fade &amp; Taper</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 65.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Classic taper fade from skin to top. Buzz cut &amp; French crop variations available.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 40 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Wolf Cut</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 70.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Soft wolf cut with wavy curls &amp; layered texture. Comma hair &amp; Korean style available.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 45 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Undercut</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 60.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Classic undercut &amp; combed-back style. Clean sides with bold top — confident &amp; sharp look.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 35 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Mullet</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 55.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Modern mullet &amp; long hair style. Business in the front, party in the back.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 30 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      {{-- Highlight card --}}
      <a href="{{ $bookUrl }}" class="svc-card relative bg-[#0a0a0a] border border-[#0a0a0a] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.20)] hover:border-[#333]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-white tracking-tight">Full Restyle</span>
          <span class="text-[0.95rem] font-bold text-white whitespace-nowrap tracking-tight">Rp 120.000</span>
        </div>
        <p class="text-[0.83rem] text-white/55 leading-relaxed flex-1 mt-1">Deep consultation + total transformation. Any style from our gallery — made just for you.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-white/50">± 75 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#b8a060] tracking-[0.04em]">RSVP →</span>
        </div>
        <span class="self-start text-[0.65rem] font-bold tracking-[0.1em] uppercase text-[#b8a060] border border-[#b8a060] px-2 py-0.5 rounded mt-2">Most Popular</span>
      </a>

    </div>
  </section>

  {{-- ── Beard & Shave ── --}}
  <section class="mt-14 max-sm:mt-10">
    <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-1">Beard</p>
    <h3 class="text-[1.55rem] font-extrabold tracking-[-0.5px] text-[#0a0a0a] mb-6 pb-4 border-b border-[#d2d2d7]">Beard &amp; Shave</h3>
    <div class="grid grid-cols-[repeat(auto-fill,minmax(260px,1fr))] gap-4 max-sm:grid-cols-1">

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Beard Trim</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 40.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Refine the shape of your beard with a razor and scissors. Includes sharp line definition.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 20 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Hot Towel Shave</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 55.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Classic shaving tradition with hot towels, premium shaving cream, and a straight razor.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 30 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      {{-- Highlight card --}}
      <a href="{{ $bookUrl }}" class="svc-card relative bg-[#0a0a0a] border border-[#0a0a0a] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.20)] hover:border-[#333]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-white tracking-tight">Cut + Beard Combo</span>
          <span class="text-[0.95rem] font-bold text-white whitespace-nowrap tracking-tight">Rp 105.000</span>
        </div>
        <p class="text-[0.83rem] text-white/55 leading-relaxed flex-1 mt-1">Precision haircut by our senior barber combined with a beard trim. The ultimate grooming package.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-white/50">± 60 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#b8a060] tracking-[0.04em]">RSVP →</span>
        </div>
        <span class="self-start text-[0.65rem] font-bold tracking-[0.1em] uppercase text-[#b8a060] border border-[#b8a060] px-2 py-0.5 rounded mt-2">Best Value</span>
      </a>

    </div>
  </section>

  {{-- ── Hair & Scalp Treatment ── --}}
  <section class="mt-14 max-sm:mt-10">
    <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-1">Treatment</p>
    <h3 class="text-[1.55rem] font-extrabold tracking-[-0.5px] text-[#0a0a0a] mb-6 pb-4 border-b border-[#d2d2d7]">Hair &amp; Scalp Treatment</h3>
    <div class="grid grid-cols-[repeat(auto-fill,minmax(260px,1fr))] gap-4 max-sm:grid-cols-1">

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Hair Wash &amp; Blow</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 35.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Premium shampoo wash + blow dry styling. The perfect add-on after a haircut.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 20 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Scalp Massage</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 45.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">15-minute scalp massage with essential oils. Total relaxation, improved circulation.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 15 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Hair Coloring</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 150.000+</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Professional hair coloring with quality products. Price varies based on length and color type.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 90 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

      <a href="{{ $bookUrl }}" class="svc-card relative bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 gap-2 shadow-[0_1px_4px_rgba(0,0,0,0.04)] transition-all duration-250 hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(0,0,0,0.09)] hover:border-[#0a0a0a]">
        <div class="flex justify-between items-baseline gap-2">
          <span class="text-[1rem] font-bold text-[#0a0a0a] tracking-tight">Pomade Styling</span>
          <span class="text-[0.95rem] font-bold text-[#0a0a0a] whitespace-nowrap tracking-tight">Rp 25.000</span>
        </div>
        <p class="text-[0.83rem] text-[#6e6e73] leading-relaxed flex-1 mt-1">Finishing with chosen pomade or wax according to hair style. Results last all day.</p>
        <div class="flex items-center justify-between mt-2">
          <span class="text-[0.72rem] font-semibold tracking-[0.05em] uppercase text-[#aeaeb2]">± 10 min</span>
          <span class="book-hint text-[0.72rem] font-bold text-[#0a0a0a] tracking-[0.04em]">RSVP →</span>
        </div>
      </a>

    </div>
  </section>

  {{-- ── Operating Hours ── --}}
  <section class="mt-14 max-sm:mt-10">
    <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-1">Schedule</p>
    <h3 class="text-[1.55rem] font-extrabold tracking-[-0.5px] text-[#0a0a0a] mb-6 pb-4 border-b border-[#d2d2d7]">Operating Hours</h3>
    <div class="overflow-hidden rounded-2xl border border-[#d2d2d7] shadow-[0_2px_8px_rgba(0,0,0,0.05)] bg-white">
      <table class="w-full border-collapse text-[0.88rem]">
        <thead class="bg-[#0a0a0a]">
          <tr>
            <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Day</th>
            <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Opening Time</th>
            <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Closing Time</th>
            <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-white/60 uppercase tracking-[0.1em]">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b border-[#f5f5f7] transition-colors hover:bg-[#f5f5f7]">
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">Monday – Friday</td>
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">09.00 AM</td>
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">21.00 PM</td>
            <td class="px-5 py-3.5 align-middle"><span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full bg-[#f0faf4] text-[#1a7a40] border border-[#b6e8cc]">Open</span></td>
          </tr>
          <tr class="border-b border-[#f5f5f7] transition-colors hover:bg-[#f5f5f7]">
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">Saturday</td>
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">08.00 AM</td>
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">22.00 PM</td>
            <td class="px-5 py-3.5 align-middle"><span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full bg-[#f0faf4] text-[#1a7a40] border border-[#b6e8cc]">Open</span></td>
          </tr>
          <tr class="border-b border-[#f5f5f7] transition-colors hover:bg-[#f5f5f7]">
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">Sunday</td>
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">09.00 AM</td>
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">20.00 PM</td>
            <td class="px-5 py-3.5 align-middle"><span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full bg-[#f0faf4] text-[#1a7a40] border border-[#b6e8cc]">Open</span></td>
          </tr>
          <tr class="transition-colors hover:bg-[#f5f5f7]">
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">National Holidays</td>
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">—</td>
            <td class="px-5 py-3.5 text-[#3a3a3c] align-middle">—</td>
            <td class="px-5 py-3.5 align-middle"><span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full bg-[#faf0f0] text-[#8a2020] border border-[#f0c0c0]">Closed</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  {{-- ── Terms & Conditions ── --}}
  <section class="mt-14 max-sm:mt-10">
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
