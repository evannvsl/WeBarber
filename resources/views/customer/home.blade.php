@extends('layouts.app')
@section('title', 'WeBarber')

@push('styles')
<style>
  .menu-card:hover .menu-card-arrow { transform: translateX(4px); }
  .team-card:hover .team-arrow { transform: translateX(4px); }

  /* Gallery: styling pakai Tailwind di markup, cuma keyframes yang perlu CSS */
  @keyframes wbRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section class="bg-[#f5f5f7] border-b border-[#d2d2d7] py-20 px-8 text-center max-sm:py-14 max-sm:px-5">
  <h2 class="text-[clamp(2.2rem,5vw,3.6rem)] font-extrabold tracking-[-1.5px] leading-none text-[#111111] mb-4">Welcome to WeBarber</h2>
  <p class="text-[1.05rem] text-[#6e6e73] max-w-[500px] mx-auto font-normal leading-relaxed">
    Our barbershop is dedicated to providing top-notch grooming services with a touch of style and precision. Whether you're looking for a classic cut or a modern look, our skilled barbers are here to make you look your best.
  </p>
</section>

<main class="max-w-[900px] mx-auto px-6 pb-24 max-sm:px-4">

  {{-- ── Gallery — editorial model look (Tailwind) ── --}}
  <section id="wbGalTop" class="my-14 scroll-mt-24">
    <div class="text-center mb-7">
      <p class="mb-2 text-[0.68rem] font-bold tracking-[0.3em] uppercase text-[#b8a060]">Our Work</p>
      <h2 class="text-[clamp(1.5rem,3.2vw,2.2rem)] font-extrabold tracking-[-0.8px] text-[#111111]">Crafted with Precision</h2>
      <span class="block w-11 h-0.5 mt-3.5 mx-auto bg-[#b8a060]"></span>
    </div>

    {{-- Tambah model baru: cukup tambah 1 baris di array ini (file, nama, tag) --}}
    @php
      $models = [
        ['01-Long Bangs.jpeg',     'Long Bangs',  'Textured Fringe'],
        ['02-Kensuke.jpeg',        'Kensuke',     'Wet-Look Curtain'],
        ['03-Jet Black Hair.jpeg', 'Jet Black',   'Buzz Cut'],
        ['04-Brown.jpeg',           'Brown Style', 'Layered Flow'],
        ['05-Wolf Cut.jpeg',              'Wavy Curls',  'Soft Wolf Cut'],
        ['06-Comma Hair.jpeg' ,           'Korean Style', 'Comma Hair'],
        ['07-Mullet.jpeg' ,           'Jayjo Windbreaker', 'Mullet'],
        ['08-Tapper Fade.jpeg' ,           'Tapper',  'Fade'],
        ['09-French Crop.jpeg' ,           'Clean',  'French Crop'],
        ['10-Long.jpeg' ,           'Jackson Irvine','Long Hair Style'],        
        ['11-Back.jpeg' ,           'Back Classic','Classic Combed-Back '],
        ['12-Undercut.jpeg' ,           'Undercut','Classic Undercut'],
        ['13-Etc.jpg' ,           'Etc','Various Styles'],
      ];
    @endphp

    @php $hasMore = count($models) > 5; @endphp
    <div id="wbGal"
      class="relative grid grid-cols-4 grid-flow-dense auto-rows-[280px] gap-3 max-sm:grid-cols-2 max-sm:auto-rows-[200px] max-sm:gap-2 {{ $hasMore ? 'overflow-hidden transition-[max-height] duration-700 ease-in-out' : '' }}"
      @if($hasMore) style="max-height:720px;-webkit-mask-image:linear-gradient(to bottom,#000 calc(100% - 150px),transparent 100%);mask-image:linear-gradient(to bottom,#000 calc(100% - 150px),transparent 100%)" @endif>
      @foreach($models as [$file, $name, $tag])
      <figure
        class="group relative isolate m-0 overflow-hidden rounded-[14px] bg-[#111111] cursor-pointer shadow-[0_2px_10px_rgba(0,0,0,0.08)] animate-[wbRise_.8s_cubic-bezier(.2,.7,.2,1)_both] motion-reduce:animate-none {{ $loop->first ? 'col-span-2 row-span-2' : '' }}"
        style="animation-delay: {{ min($loop->index, 8) * 0.08 }}s">

        <img src="{{ asset('img/' . $file) }}" alt="{{ $name }}" loading="lazy"
          class="block w-full h-full object-cover object-[center_25%] grayscale-[30%] contrast-[1.03] transition duration-[900ms] ease-out group-hover:scale-[1.07] group-hover:grayscale-0 group-hover:contrast-[1.05] motion-reduce:transition-none" />

        {{-- gradient bawah biar caption terbaca --}}
        <div class="pointer-events-none absolute inset-0 z-[1] bg-[linear-gradient(to_top,rgba(0,0,0,0.78)_0%,rgba(0,0,0,0.18)_42%,rgba(0,0,0,0)_65%)]"></div>

        {{-- bingkai emas tipis saat hover --}}
        <div class="pointer-events-none absolute inset-[10px] z-[2] rounded-[9px] border border-[#b8a060]/0 transition-all duration-500 group-hover:inset-2 group-hover:border-[#b8a060]/85"></div>

        <figcaption class="absolute inset-x-0 bottom-0 z-[3] px-[1.15rem] pt-[1.1rem] pb-[1.05rem] text-white translate-y-1.5 transition-transform duration-500 group-hover:translate-y-0 [@media(hover:none)]:translate-y-0">
          <span class="block mb-0.5 text-[0.66rem] font-bold tracking-[0.22em] text-[#b8a060]">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          <span class="block font-extrabold leading-tight {{ $loop->first ? 'text-[1.5rem] tracking-[-0.5px] max-sm:text-[1.2rem]' : 'text-[0.95rem] tracking-[-0.2px]' }}">{{ $name }}</span>
          <span class="block max-h-0 overflow-hidden opacity-0 text-[0.68rem] font-semibold tracking-[0.14em] uppercase text-white/70 transition-all duration-500 group-hover:max-h-8 group-hover:opacity-100 group-hover:mt-1.5 [@media(hover:none)]:max-h-8 [@media(hover:none)]:opacity-100 [@media(hover:none)]:mt-1.5">{{ $tag }}</span>
        </figcaption>
      </figure>
      @endforeach
    </div>

    @if($hasMore)
    <div class="mt-7 text-center">
      <button type="button" id="wbGalBtn" aria-expanded="false" aria-controls="wbGal"
        class="inline-flex items-center gap-2 rounded-full border border-[#111111] bg-transparent px-6 py-3 text-[0.8rem] font-semibold tracking-[0.04em] text-[#111111] cursor-pointer transition-colors duration-200 hover:bg-[#111111] hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-[#b8a060] focus-visible:ring-offset-2">
        <span data-label>View more ({{ count($models) - 5 }})</span>
        <svg class="h-4 w-4 transition-transform duration-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
      </button>
    </div>

    <script>
      (function () {
        var grid = document.getElementById('wbGal');
        var btn  = document.getElementById('wbGalBtn');
        if (!grid || !btn || grid.children.length < 6) return;

        var items = grid.children, peek = 130, open = false;
        var label = btn.querySelector('[data-label]');
        var icon  = btn.querySelector('svg');
        var total = items.length - 5;
        var maskOn  = 'linear-gradient(to bottom,#000 calc(100% - ' + (peek + 20) + 'px),transparent 100%)';

        function setMask(v) { grid.style.webkitMaskImage = v; grid.style.maskImage = v; }
        function collapsedH() {
          return items[5].getBoundingClientRect().top - grid.getBoundingClientRect().top + peek;
        }

        function expand() {
          open = true;
          grid.style.maxHeight = grid.scrollHeight + 'px';
          setMask('none');
          label.textContent = 'Show less';
          icon.style.transform = 'rotate(180deg)';
          btn.setAttribute('aria-expanded', 'true');
          grid.style.cursor = '';
        }
        function collapse() {
          open = false;
          grid.style.maxHeight = grid.scrollHeight + 'px';   // dari 'none' ke angka dulu biar transisi jalan
          void grid.offsetHeight;
          grid.style.maxHeight = collapsedH() + 'px';
          setMask(maskOn);
          label.textContent = 'View more (' + total + ')';
          icon.style.transform = '';
          btn.setAttribute('aria-expanded', 'false');
          document.getElementById('wbGalTop').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        grid.addEventListener('transitionend', function (e) {
          if (e.propertyName === 'max-height' && open) grid.style.maxHeight = 'none';
        });
        btn.addEventListener('click', function () { open ? collapse() : expand(); });
        // klik preview juga membuka galeri
        grid.addEventListener('click', function () { if (!open) expand(); });
        window.addEventListener('resize', function () { if (!open) grid.style.maxHeight = collapsedH() + 'px'; });

        // state awal (tutup)
        grid.style.maxHeight = collapsedH() + 'px';
        setMask(maskOn);
        grid.style.cursor = 'pointer';
      })();
    </script>
    @endif
  </section>

  {{-- ── Services — cards link ke booking ── --}}
  <section class="mb-8 p-10 border border-[#d2d2d7] rounded-2xl bg-[#f5f5f7] shadow-[0_1px_4px_rgba(0,0,0,0.04),0_4px_16px_rgba(0,0,0,0.05)] max-sm:p-6">
    <p class="block text-[0.68rem] font-bold tracking-[0.28em] uppercase text-[#aeaeb2] mb-1">What We Offer</p>
    <h2 class="text-[clamp(1.5rem,3vw,2rem)] font-extrabold tracking-[-0.6px] text-[#111111] mb-5">Our Services</h2>
    <div class="grid grid-cols-3 gap-3 mb-6 max-sm:grid-cols-1">

      {{-- Haircut — card hitam, link ke reservation form di Contact --}}
      <a href="{{ route('barbers') }}#reservation" class="menu-card flex flex-col gap-1 p-6 rounded-xl border border-[#111111] bg-[#111111] no-underline transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_6px_24px_rgba(0,0,0,0.18)]">
        <span class="text-[0.65rem] font-bold tracking-[0.18em] uppercase text-white/35">Haircut &amp; Styling</span>
        <span class="text-[1.05rem] font-bold tracking-tight text-white my-0.5">Premium Cuts</span>
        <span class="text-[0.78rem] text-white/45 leading-relaxed flex-1">Signature, Fade, Undercut &amp; more</span>
        <span class="menu-card-arrow text-[0.9rem] text-white/50 mt-3 transition-transform duration-200">Reserve now →</span>
      </a>

      {{-- Beard — card putih, link ke reservation form di Contact --}}
      <a href="{{ route('barbers') }}#reservation" class="menu-card flex flex-col gap-1 p-6 rounded-xl border border-[#d2d2d7] bg-white no-underline transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_6px_24px_rgba(0,0,0,0.10)] hover:border-[#c2c2c7]">
        <span class="text-[0.65rem] font-bold tracking-[0.18em] uppercase text-[#aeaeb2]">Beard</span>
        <span class="text-[1.05rem] font-bold tracking-tight text-[#111111] my-0.5">Beard &amp; Shave</span>
        <span class="text-[0.78rem] text-[#6e6e73] leading-relaxed flex-1">Trim, Hot Towel &amp; Combo package</span>
        <span class="menu-card-arrow text-[0.9rem] text-[#aeaeb2] mt-3 transition-transform duration-200">Reserve now →</span>
      </a>

      {{-- Treatment — card putih, link ke reservation form di Contact --}}
      <a href="{{ route('barbers') }}#reservation" class="menu-card flex flex-col gap-1 p-6 rounded-xl border border-[#d2d2d7] bg-white no-underline transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_6px_24px_rgba(0,0,0,0.10)] hover:border-[#c2c2c7]">
        <span class="text-[0.65rem] font-bold tracking-[0.18em] uppercase text-[#aeaeb2]">Treatment</span>
        <span class="text-[1.05rem] font-bold tracking-tight text-[#111111] my-0.5">Hair Care</span>
        <span class="text-[0.78rem] text-[#6e6e73] leading-relaxed flex-1">Scalp massage, coloring &amp; styling</span>
        <span class="menu-card-arrow text-[0.9rem] text-[#aeaeb2] mt-3 transition-transform duration-200">Reserve now →</span>
      </a>

    </div>
    <a href="{{ route('services') }}" class="inline-flex items-center gap-1.5 text-[0.82rem] font-semibold text-[#111111] no-underline border-b border-[#111111] pb-px tracking-[0.02em] transition-opacity hover:opacity-55">
      View Full Menu &amp; Pricing →
    </a>
  </section>

  {{-- ── Our Teams ── --}}
  <section class="mb-8 p-10 border border-[#222] rounded-2xl bg-[#111111] max-sm:p-6">
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
        <span class="team-arrow text-[0.9rem] text-white/25 transition-transform duration-200">→</span>
      </a>
      @empty
      <a href="{{ route('barbers') }}" class="team-card flex items-center gap-4 px-5 py-4 bg-white/5 border border-white/10 rounded-xl no-underline transition-all duration-200 hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5">
        <div class="w-11 h-11 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-[1rem] font-extrabold text-white/75 shrink-0">E</div>
        <div class="flex flex-col gap-0.5 flex-1">
          <span class="text-[0.95rem] font-bold text-white tracking-tight">Evan</span>
          <span class="text-[0.75rem] font-medium text-white/35">Founder &amp; Head Barber</span>
        </div>
        <span class="team-arrow text-[0.9rem] text-white/25 transition-transform duration-200">→</span>
      </a>
      <a href="{{ route('barbers') }}" class="team-card flex items-center gap-4 px-5 py-4 bg-white/5 border border-white/10 rounded-xl no-underline transition-all duration-200 hover:bg-white/10 hover:border-white/20 hover:-translate-y-0.5">
        <div class="w-11 h-11 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-[1rem] font-extrabold text-white/75 shrink-0">F</div>
        <div class="flex flex-col gap-0.5 flex-1">
          <span class="text-[0.95rem] font-bold text-white tracking-tight">Fairus</span>
          <span class="text-[0.75rem] font-medium text-white/35">Co-Founder &amp; Operations Manager</span>
        </div>
        <span class="team-arrow text-[0.9rem] text-white/25 transition-transform duration-200">→</span>
      </a>
      @endforelse
    </div>
  </section>

</main>
@endsection