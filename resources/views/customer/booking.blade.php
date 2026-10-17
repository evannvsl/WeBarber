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
    <div class="flex flex-col gap-2">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Pilih Layanan
        <span class="text-[#aeaeb2] font-normal">(bisa lebih dari satu)</span>
      </label>
      <div class="grid grid-cols-2 gap-3 max-sm:grid-cols-1">
        @foreach($services as $service)
        <label class="flex items-start gap-3 p-4 border border-[#d2d2d7] rounded-xl bg-white cursor-pointer transition-colors hover:border-[#b8a060] has-[:checked]:border-[#111111] has-[:checked]:bg-[#f5f5f7]">
          <input type="checkbox" name="service_ids[]" value="{{ $service->id }}"
            {{ in_array($service->id, old('service_ids', [])) ? 'checked' : '' }}
            class="mt-0.5 w-4 h-4 rounded accent-[#111111] shrink-0" />
          <div class="flex flex-col gap-0.5 min-w-0">
            <span class="text-[0.88rem] font-semibold text-[#111111] leading-tight">{{ $service->name }}</span>
            <span class="text-[0.76rem] text-[#6e6e73]">{{ $service->price_formatted }} · ± {{ $service->duration_minutes }} min</span>
          </div>
        </label>
        @endforeach
      </div>
      @if($errors->has('service_ids'))
      <p class="text-[0.78rem] text-red-600 font-medium">Pilih minimal satu layanan.</p>
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
@endsection
