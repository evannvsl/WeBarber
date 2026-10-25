@extends('layouts.app')
@section('title', 'WeBarber | Book Appointment')

@section('content')

<section class="relative bg-[#0a0a0a] py-20 px-8 text-center overflow-hidden max-sm:py-14">
  <p class="text-[0.7rem] font-bold tracking-[0.3em] uppercase text-[#b8a060] mb-4">Reservations</p>
  <h2 class="text-[clamp(2rem,5vw,3.4rem)] font-extrabold tracking-[-1px] text-white leading-none mb-4">Book Your Session.</h2>
  <p class="text-[0.7rem] font-light italic text-white/45 max-w-[440px] mx-auto">Ready to look your best? Fill out the form below.</p>
</section>

<main class="max-w-[720px] mx-auto px-6 pb-24 pt-12 max-sm:px-4">

  {{-- ✓ Sukses --}}
  @if(session('success'))
  <div class="mb-6 flex items-center gap-3 px-4 py-3.5 bg-green-50 border border-green-200 rounded-2xl text-[0.88rem] text-green-800 font-medium">
    <span class="text-green-600 text-base">✓</span>
    {{ session('success') }}
  </div>
  @endif

  {{-- ⚠ Slot Penuh / Error --}}
  @if($errors->any())
  <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 overflow-hidden">
    {{-- Header notif --}}
    <div class="flex items-center gap-3 px-5 py-3.5 bg-red-100 border-b border-red-200">
      <span class="text-red-600 text-[1.1rem]">⚠</span>
      <p class="text-[0.88rem] font-bold text-red-800">
        @if($errors->has('start_time') && str_contains($errors->first('start_time'), 'jadwal'))
          Slot Waktu Tidak Tersedia
        @else
          Perhatian — Booking Tidak Berhasil
        @endif
      </p>
    </div>
    {{-- Detail error --}}
    <div class="px-5 py-4 flex flex-col gap-2">
      @foreach($errors->all() as $error)
      <p class="text-[0.85rem] text-red-700 flex items-start gap-2">
        <span class="mt-0.5 shrink-0">—</span>
        <span>
          @if(str_contains($error, 'jadwal'))
            <strong>Barber sudah memiliki jadwal di waktu tersebut.</strong> Silakan pilih waktu atau barber yang berbeda.
          @else
            {{ $error }}
          @endif
        </span>
      </p>
      @endforeach
    </div>
    {{-- Saran --}}
    @if($errors->has('start_time'))
    <div class="px-5 py-3 bg-red-50 border-t border-red-100 text-[0.8rem] text-red-600">
      💡 <strong>Tips:</strong> Coba pilih jam berbeda, atau pilih barber lain yang tersedia.
    </div>
    @endif
  </div>
  @endif

  <form method="POST" action="{{ route('customer.booking.store') }}" class="flex flex-col gap-6">
    @csrf

    {{-- Baris 1: Barber + Tanggal --}}
    <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">

      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Pilih Barber</label>
        <select name="barber_id" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] text-[#1d1d1f] {{ $errors->has('barber_id') ? 'border-red-400' : '' }}">
          <option value="" disabled selected>Pilih barber</option>
          @foreach($barbers as $barber)
          <option value="{{ $barber->id }}" {{ old('barber_id') == $barber->id ? 'selected' : '' }}>
            {{ $barber->user->name }} — {{ $barber->specialty ?? 'Barber' }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Tanggal Reservasi</label>
        <input type="date" name="booking_date"
          value="{{ old('booking_date') }}"
          min="{{ date('Y-m-d') }}" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] {{ $errors->has('booking_date') ? 'border-red-400' : '' }}" />
      </div>

    </div>

    {{-- Baris 2: Jam --}}
    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Jam Mulai
        <span class="text-[#aeaeb2] font-normal">(09:00 – 21:00)</span>
      </label>
      <input type="time" name="start_time"
        value="{{ old('start_time') }}"
        min="09:00" max="21:00" required
        class="w-full max-w-[220px] px-4 py-2.5 text-[0.9rem] border rounded-xl bg-white outline-none transition-colors focus:border-[#111111]
          {{ $errors->has('start_time') ? 'border-red-400 bg-red-50' : 'border-[#d2d2d7]' }}" />
      @if($errors->has('start_time'))
      <p class="text-[0.78rem] text-red-600 font-medium flex items-center gap-1 mt-0.5">
        <span>⚠</span> Waktu ini sudah terisi. Pilih jam lain.
      </p>
      @endif
    </div>

    {{-- Services --}}
    <div class="flex flex-col gap-3">
      <div class="flex items-baseline justify-between">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Pilih Layanan
          <span class="text-[#aeaeb2] font-normal">(bisa lebih dari satu)</span>
        </label>
        {{-- Total harga & durasi realtime --}}
        <span id="svc-summary" class="text-[0.78rem] font-semibold text-[#111111] hidden">
          <span id="svc-total"></span> · <span id="svc-duration"></span>
        </span>
      </div>

      <div class="grid grid-cols-2 gap-3 max-sm:grid-cols-1">
        @foreach($services as $service)
        @php $checked = in_array($service->id, old('service_ids', [])); @endphp
        <label
          data-price="{{ $service->price }}"
          data-duration="{{ $service->duration_minutes }}"
          class="svc-card group relative flex flex-col gap-1.5 px-5 py-4 border rounded-2xl bg-white cursor-pointer
                 transition-all duration-200 hover:-translate-y-0.5
                 hover:shadow-[0_4px_16px_rgba(0,0,0,0.08)] hover:border-[#0a0a0a]
                 {{ $checked ? 'border-[#111111] bg-[#0a0a0a] shadow-[0_4px_16px_rgba(0,0,0,0.12)]' : 'border-[#d2d2d7]' }}">

          {{-- Checkbox tersembunyi --}}
          <input type="checkbox" name="service_ids[]" value="{{ $service->id }}"
            {{ $checked ? 'checked' : '' }}
            class="sr-only svc-check" />

          {{-- Checkmark pojok kanan atas --}}
          <span class="svc-tick absolute top-3 right-3 w-5 h-5 rounded-full border flex items-center justify-center text-[0.65rem] font-bold transition-all
            {{ $checked ? 'bg-[#b8a060] border-[#b8a060] text-white' : 'border-[#d2d2d7] text-transparent' }}">✓</span>

          {{-- Nama & harga --}}
          <div class="flex items-baseline justify-between gap-2 pr-6">
            <span class="svc-name text-[0.95rem] font-bold tracking-tight leading-tight transition-colors
              {{ $checked ? 'text-white' : 'text-[#0a0a0a]' }}">
              {{ $service->name }}
            </span>
            <span class="svc-price text-[0.9rem] font-bold whitespace-nowrap transition-colors
              {{ $checked ? 'text-[#b8a060]' : 'text-[#0a0a0a]' }}">
              {{ $service->price_formatted }}
            </span>
          </div>

          {{-- Deskripsi --}}
          @if($service->description)
          <p class="svc-desc text-[0.78rem] leading-relaxed transition-colors
            {{ $checked ? 'text-white/55' : 'text-[#6e6e73]' }}">
            {{ Str::limit($service->description, 80) }}
          </p>
          @endif

          {{-- Durasi --}}
          <div class="flex items-center justify-between mt-1">
            <span class="svc-dur text-[0.7rem] font-semibold tracking-[0.05em] uppercase transition-colors
              {{ $checked ? 'text-white/45' : 'text-[#aeaeb2]' }}">
              ± {{ $service->duration_minutes }} min
            </span>
            <span class="svc-hint text-[0.7rem] font-bold tracking-[0.04em] transition-colors
              {{ $checked ? 'text-[#b8a060]' : 'text-transparent group-hover:text-[#0a0a0a]' }}">
              {{ $checked ? 'DIPILIH ✓' : 'PILIH →' }}
            </span>
          </div>
        </label>
        @endforeach
      </div>

      @if($errors->has('service_ids'))
      <p class="text-[0.78rem] text-red-600 font-medium flex items-center gap-1">
        <span>⚠</span> Pilih minimal satu layanan.
      </p>
      @endif
    </div>

    {{-- Catatan --}}
    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Catatan untuk Barber
        <span class="text-[#aeaeb2] font-normal">(opsional)</span>
      </label>
      <textarea name="notes" rows="3"
        placeholder="Contoh: Mau model rambut apa? Referensi foto?"
        class="w-full px-4 py-3 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] resize-none placeholder:text-[#aeaeb2]">{{ old('notes') }}</textarea>
    </div>

    {{-- Submit --}}
    <div class="flex items-center gap-3 pt-1">
      <button type="submit"
        class="px-8 py-2.5 bg-[#111111] text-white text-[0.9rem] font-semibold rounded-full transition-opacity hover:opacity-80 cursor-pointer border-0">
        Buat Reservasi
      </button>
      <button type="reset"
        class="px-6 py-2.5 border border-[#d2d2d7] text-[#6e6e73] text-[0.9rem] font-semibold rounded-full transition-colors hover:bg-[#f5f5f7] cursor-pointer bg-transparent">
        Reset
      </button>
    </div>
  </form>

</main>
@push('scripts')
<script>
  const cards = document.querySelectorAll('.svc-card');
  const summaryEl = document.getElementById('svc-summary');
  const totalEl   = document.getElementById('svc-total');
  const durEl     = document.getElementById('svc-duration');

  function formatRp(n) {
    return 'Rp ' + n.toLocaleString('id-ID');
  }

  function updateSummary() {
    let total = 0, mins = 0, count = 0;
    cards.forEach(card => {
      const cb = card.querySelector('.svc-check');
      if (cb.checked) {
        total += parseFloat(card.dataset.price);
        mins  += parseInt(card.dataset.duration);
        count++;
      }
    });
    if (count > 0) {
      totalEl.textContent = formatRp(total);
      durEl.textContent   = '± ' + mins + ' min';
      summaryEl.classList.remove('hidden');
    } else {
      summaryEl.classList.add('hidden');
    }
  }

  function applyStyle(card, checked) {
    const cb      = card.querySelector('.svc-check');
    const tick    = card.querySelector('.svc-tick');
    const nameEl  = card.querySelector('.svc-name');
    const priceEl = card.querySelector('.svc-price');
    const descEl  = card.querySelector('.svc-desc');
    const durEl2  = card.querySelector('.svc-dur');
    const hintEl  = card.querySelector('.svc-hint');

    if (checked) {
      card.classList.add('border-[#111111]', 'bg-[#0a0a0a]', 'shadow-[0_4px_16px_rgba(0,0,0,0.12)]', '-translate-y-0.5');
      card.classList.remove('border-[#d2d2d7]', 'bg-white');
      tick.classList.add('bg-[#b8a060]', 'border-[#b8a060]', 'text-white');
      tick.classList.remove('border-[#d2d2d7]', 'text-transparent');
      nameEl.classList.add('text-white'); nameEl.classList.remove('text-[#0a0a0a]');
      priceEl.classList.add('text-[#b8a060]'); priceEl.classList.remove('text-[#0a0a0a]');
      if (descEl) { descEl.classList.add('text-white/55'); descEl.classList.remove('text-[#6e6e73]'); }
      durEl2.classList.add('text-white/45'); durEl2.classList.remove('text-[#aeaeb2]');
      hintEl.textContent = 'DIPILIH ✓';
      hintEl.classList.add('text-[#b8a060]'); hintEl.classList.remove('text-transparent', 'group-hover:text-[#0a0a0a]');
    } else {
      card.classList.remove('border-[#111111]', 'bg-[#0a0a0a]', 'shadow-[0_4px_16px_rgba(0,0,0,0.12)]', '-translate-y-0.5');
      card.classList.add('border-[#d2d2d7]', 'bg-white');
      tick.classList.remove('bg-[#b8a060]', 'border-[#b8a060]', 'text-white');
      tick.classList.add('border-[#d2d2d7]', 'text-transparent');
      nameEl.classList.remove('text-white'); nameEl.classList.add('text-[#0a0a0a]');
      priceEl.classList.remove('text-[#b8a060]'); priceEl.classList.add('text-[#0a0a0a]');
      if (descEl) { descEl.classList.remove('text-white/55'); descEl.classList.add('text-[#6e6e73]'); }
      durEl2.classList.remove('text-white/45'); durEl2.classList.add('text-[#aeaeb2]');
      hintEl.textContent = 'PILIH →';
      hintEl.classList.remove('text-[#b8a060]'); hintEl.classList.add('text-transparent', 'group-hover:text-[#0a0a0a]');
    }
  }

  cards.forEach(card => {
    const cb = card.querySelector('.svc-check');

    // Init state untuk yang sudah checked (old input)
    applyStyle(card, cb.checked);

    card.addEventListener('click', () => {
      cb.checked = !cb.checked;
      applyStyle(card, cb.checked);
      updateSummary();
    });
  });

  updateSummary();
</script>
@endpush

@endsection
