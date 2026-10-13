@extends('layouts.app')
@section('title', 'WeBarber — Home')

@push('styles')
<style>
  .gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 1.2rem;
  }
  .gallery-featured { grid-column: 1 / 3; grid-row: 1; aspect-ratio: 16/9; }
  .gallery-grid > div:nth-child(2) { grid-column: 3; grid-row: 1; }
  .gallery-grid > div:nth-child(3) { grid-column: 4; grid-row: 1; }
  .gallery-grid > div:nth-child(4) { grid-column: 1; grid-row: 2; }
  .gallery-grid > div:nth-child(5) { grid-column: 2; grid-row: 2; }
  .gallery-grid > div:nth-child(6) { grid-column: 3; grid-row: 2; }
  .gallery-grid > div:nth-child(7) { grid-column: 4; grid-row: 2; }
  .gallery-item img { filter: grayscale(15%); }
  .gallery-item:hover img { transform: scale(1.06); filter: grayscale(0%); }
  .gallery-item:hover .gallery-overlay { opacity: 1; }
  .gallery-overlay { background: linear-gradient(to top, rgba(0,0,0,0.62) 0%, rgba(0,0,0,0) 55%); }
  .menu-card:hover .menu-card-arrow { transform: translateX(4px); }
  .team-card:hover .team-arrow { transform: translateX(4px); }
  @media (max-width: 768px) {
    .gallery-grid { grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .gallery-featured { grid-column: 1 / 3; grid-row: 1; }
    .gallery-grid > div:nth-child(2) { grid-column: 3; grid-row: 1; }
    .gallery-grid > div:nth-child(3) { grid-column: 1; grid-row: 2; }
    .gallery-grid > div:nth-child(4) { grid-column: 2; grid-row: 2; }
    .gallery-grid > div:nth-child(5) { grid-column: 3; grid-row: 2; }
    .gallery-grid > div:nth-child(6) { grid-column: 1; grid-row: 3; }
    .gallery-grid > div:nth-child(7) { grid-column: 2; grid-row: 3; }
  }
  @media (max-width: 600px) {
    .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; }
    .gallery-featured { grid-column: 1 / 3; grid-row: 1; aspect-ratio: 16/9; }
    .gallery-grid > div:nth-child(2) { grid-column: 1; grid-row: 2; }
    .gallery-grid > div:nth-child(3) { grid-column: 2; grid-row: 2; }
    .gallery-overlay { opacity: 1; }
  }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="bg-[#f5f5f7] border-b border-[#d2d2d7] py-20 px-8 text-center">
  <h2 class="text-[clamp(2.2rem,5vw,3.6rem)] font-extrabold tracking-[-1.5px] leading-none text-[#111111] mb-4">Welcome to WeBarber</h2>
  <p class="text-[1.1rem] text-[#6e6e73] max-w-[500px] mx-auto font-normal">
    Our barbershop is dedicated to providing top-notch grooming services with a touch of style and precision. Whether you're looking for a classic cut or a modern look, our skilled barbers are here to make you look your best.
  </p>
  @guest
  <div class="flex items-center justify-center gap-3 mt-8">
    <a href="{{ route('customer.booking') }}"
       class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#111111] text-white text-[0.88rem] font-semibold rounded-full no-underline transition-opacity hover:opacity-75">
      Book Now
    </a>
    <a href="{{ route('services') }}"
       class="inline-flex items-center gap-2 px-6 py-2.5 border border-[#d2d2d7] text-[#111111] text-[0.88rem] font-semibold rounded-full no-underline transition-colors hover:bg-[#f5f5f7]">
      View Menu →
    </a>
  </div>
  @else
  <div class="mt-8">
    <a href="{{ route('customer.booking') }}"
       class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#111111] text-white text-[0.88rem] font-semibold rounded-full no-underline transition-opacity hover:opacity-75">
      Book Now
    </a>
  </div>
  @endguest
</section>

<main class="max-w-[900px] mx-auto px-6 pb-24">

  {{-- Gallery --}}
  <section class="my-14">
    <h2 class="text-[clamp(1.4rem,3vw,2rem)] font-extrabold tracking-[-0.6px] text-[#111111] text-center">Crafted with Precision</h2>
    <p class="text-[0.72rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] text-center -mt-2 mb-4">Our Work</p>
    <div class="gallery-grid">
      <div class="gallery-item gallery-featured relative overflow-hidden rounded-[10px] bg-[#e8e8ed] cursor-pointer">
        <img src="{{ asset('img/img7.avif') }}" alt="Featured Cut" class="w-full h-full object-cover block transition-transform duration-500 ease-out" />
        <div class="gallery-overlay absolute inset-0 flex items-end px-[1.1rem] pb-4 opacity-0 transition-opacity duration-300">
          <span class="text-[0.82rem] font-bold tracking-[0.08em] uppercase text-white/90">Signature Cut</span>
        </div>
      </div>
      <div class="gallery-item relative overflow-hidden rounded-[10px] bg-[#e8e8ed] aspect-square cursor-pointer">
        <img src="{{ asset('img/img1.jpg') }}" alt="Beard Trim" class="w-full h-full object-cover block transition-transform duration-500 ease-out" />
        <div class="gallery-overlay absolute inset-0 flex items-end px-[1.1rem] pb-4 opacity-0 transition-opacity duration-300">
          <span class="text-[0.82rem] font-bold tracking-[0.08em] uppercase text-white/90">Beard Trim</span>
        </div>
      </div>
      <div class="gallery-item relative overflow-hidden rounded-[10px] bg-[#e8e8ed] aspect-square cursor-pointer">
        <img src="{{ asset('img/img2.jpg') }}" alt="Stair Cut" class="w-full h-full object-cover block transition-transform duration-500 ease-out" />
        <div class="gallery-overlay absolute inset-0 flex items-end px-[1.1rem] pb-4 opacity-0 transition-opacity duration-300">
          <span class="text-[0.82rem] font-bold tracking-[0.08em] uppercase text-white/90">Stair Cut</span>
        </div>
      </div>
      <div class="gallery-item relative overflow-hidden rounded-[10px] bg-[#e8e8ed] aspect-square cursor-pointer">
        <img src="{{ asset('img/img3.jpg') }}" alt="Modern Mullet" class="w-full h-full object-cover block transition-transform duration-500 ease-out" />
        <div class="gallery-overlay absolute inset-0 flex items-end px-[1.1rem] pb-4 opacity-0 transition-opacity duration-300">
          <span class="text-[0.82rem] font-bold tracking-[0.08em] uppercase text-white/90">Modern Mullet</span>
        </div>
      </div>
      <div class="gallery-item relative overflow-hidden rounded-[10px] bg-[#e8e8ed] aspect-square cursor-pointer">
        <img src="{{ asset('img/img4.jpg') }}" alt="Undercut" class="w-full h-full object-cover block transition-transform duration-500 ease-out" />
        <div class="gallery-overlay absolute inset-0 flex items-end px-[1.1rem] pb-4 opacity-0 transition-opacity duration-300">
          <span class="text-[0.82rem] font-bold tracking-[0.08em] uppercase text-white/90">Undercut</span>
        </div>
      </div>
      <div class="gallery-item relative overflow-hidden rounded-[10px] bg-[#e8e8ed] aspect-square cursor-pointer">
        <img src="{{ asset('img/img5.jpg') }}" alt="French Crop" class="w-full h-full object-cover block transition-transform duration-500 ease-out" />
        <div class="gallery-overlay absolute inset-0 flex items-end px-[1.1rem] pb-4 opacity-0 transition-opacity duration-300">
          <span class="text-[0.82rem] font-bold tracking-[0.08em] uppercase text-white/90">French Crop</span>
        </div>
      </div>
      <div class="gallery-item relative overflow-hidden rounded-[10px] bg-[#e8e8ed] aspect-square cursor-pointer">
        <img src="{{ asset('img/img6.jpeg') }}" alt="Mode on" class="w-full h-full object-cover block transition-transform duration-500 ease-out" />
        <div class="gallery-overlay absolute inset-0 flex items-end px-[1.1rem] pb-4 opacity-0 transition-opacity duration-300">
          <span class="text-[0.82rem] font-bold tracking-[0.08em] uppercase text-white/90">Mode on</span>
        </div>
      </div>
    </div>
  </section>

  {{-- Services preview --}}
  <section class="mb-8 p-10 border border-[#d2d2d7] rounded-2xl bg-[#f5f5f7] shadow-[0_1px_4px_rgba(0,0,0,0.04),0_4px_16px_rgba(0,0,0,0.05)]">
    <p class="block text-[0.68rem] font-bold tracking-[0.28em] uppercase text-[#aeaeb2] mb-1">What We Offer</p>
    <h2 class="text-[clamp(1.5rem,3vw,2rem)] font-extrabold tracking-[-0.6px] text-[#111111] mb-5">Our Services</h2>
    <div class="grid grid-cols-3 gap-3 mb-6 max-sm:grid-cols-1">
      <a href="{{ route('services') }}" class="menu-card flex flex-col gap-1 p-6 rounded-xl border border-[#111111] bg-[#111111] no-underline relative overflow-hidden transition-all duration-200 shadow-[0_1px_4px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:shadow-[0_6px_24px_rgba(0,0,0,0.10)]">
        <span class="text-[0.65rem] font-bold tracking-[0.18em] uppercase text-white/35">Haircut &amp; Styling</span>
        <span class="text-[1.05rem] font-bold tracking-tight text-white my-0.5">Premium Cuts</span>
        <span class="text-[0.78rem] text-white/45 leading-relaxed flex-1">Signature, Fade, Undercut &amp; more</span>
        <span class="menu-card-arrow text-[1rem] text-white/50 mt-3 transition-all duration-200">→</span>
      </a>
      <a href="{{ route('services') }}" class="menu-card flex flex-col gap-1 p-6 rounded-xl border border-[#d2d2d7] bg-white no-underline relative overflow-hidden transition-all duration-200 shadow-[0_1px_4px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:shadow-[0_6px_24px_rgba(0,0,0,0.10)] hover:border-[#c2c2c7]">
        <span class="text-[0.65rem] font-bold tracking-[0.18em] uppercase text-[#aeaeb2]">Beard</span>
        <span class="text-[1.05rem] font-bold tracking-tight text-[#111111] my-0.5">Beard &amp; Shave</span>
        <span class="text-[0.78rem] text-[#6e6e73] leading-relaxed flex-1">Trim, Hot Towel &amp; Combo package</span>
        <span class="menu-card-arrow text-[1rem] text-[#aeaeb2] mt-3 transition-all duration-200">→</span>
      </a>
      <a href="{{ route('services') }}" class="menu-card flex flex-col gap-1 p-6 rounded-xl border border-[#d2d2d7] bg-white no-underline relative overflow-hidden transition-all duration-200 shadow-[0_1px_4px_rgba(0,0,0,0.04)] hover:-translate-y-1 hover:shadow-[0_6px_24px_rgba(0,0,0,0.10)] hover:border-[#c2c2c7]">
        <span class="text-[0.65rem] font-bold tracking-[0.18em] uppercase text-[#aeaeb2]">Treatment</span>
        <span class="text-[1.05rem] font-bold tracking-tight text-[#111111] my-0.5">Hair Care</span>
        <span class="text-[0.78rem] text-[#6e6e73] leading-relaxed flex-1">Scalp massage, coloring &amp; styling</span>
        <span class="menu-card-arrow text-[1rem] text-[#aeaeb2] mt-3 transition-all duration-200">→</span>
      </a>
    </div>
    <a href="{{ route('services') }}" class="inline-flex items-center gap-1.5 text-[0.82rem] font-semibold text-[#111111] no-underline border-b border-[#111111] pb-px tracking-[0.02em] transition-opacity hover:opacity-55">
      View Full Menu &amp; Pricing →
    </a>
  </section>

  {{-- Team --}}
  <section class="mb-8 p-10 border border-[#222] rounded-2xl bg-[#111111]">
    <h2 class="text-[clamp(1.5rem,3vw,2rem)] font-extrabold tracking-[-0.6px] text-white mb-5">Our Teams</h2>
    <div class="grid grid-cols-2 gap-3 max-sm:grid-cols-1">
      @forelse($barbers as $barber)
      <a href="{{ route('barbers') }}" class="team-card flex items-center gap-4 px-5 py-4 bg-white/5 border border-white/10 rounded-xl no-underline transition-all duration-200 hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5">
        <div class="w-11 h-11 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-[1rem] font-extrabold text-white/75 tracking-tight shrink-0">
          {{ strtoupper(substr($barber->user->name, 0, 1)) }}
        </div>
        <div class="flex flex-col gap-0.5 flex-1">
          <span class="text-[0.95rem] font-bold text-white tracking-tight">{{ $barber->user->name }}</span>
          <span class="text-[0.75rem] font-medium text-white/35 tracking-[0.02em]">{{ $barber->specialty ?? 'Professional Barber' }}</span>
        </div>
        <span class="team-arrow text-[0.9rem] text-white/25 transition-all duration-200">→</span>
      </a>
      @empty
      <p class="text-white/45 text-[0.85rem] col-span-2">No barbers available yet.</p>
      @endforelse
    </div>
  </section>

</main>
@endsection
