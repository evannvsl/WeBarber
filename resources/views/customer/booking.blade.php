@extends('layouts.app')
@section('title', 'WeBarber — Book Appointment')

@section('content')

<section class="relative bg-[#0a0a0a] py-20 px-8 text-center overflow-hidden">
  <p class="text-[0.7rem] font-bold tracking-[0.3em] uppercase text-[#b8a060] mb-4">Reservations</p>
  <h2 class="text-[clamp(2rem,5vw,3.4rem)] font-extrabold tracking-[-1px] text-white leading-none mb-4">Book Your Session.</h2>
  <p class="text-[0.7rem] font-light italic text-white/45 max-w-[440px] mx-auto">Ready to look your best? Fill out the form below.</p>
</section>

<main class="max-w-[720px] mx-auto px-6 pb-24 pt-14">

  @if(session('success'))
  <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-[0.85rem] text-green-800">
    <span>✓</span> {{ session('success') }}
  </div>
  @endif
  @if($errors->any())
  <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-[0.85rem] text-red-800">
    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
  </div>
  @endif

  <form method="POST" action="{{ route('customer.booking.store') }}" class="flex flex-col gap-6">
    @csrf

    <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">

      {{-- Barber selection --}}
      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Choose Barber</label>
        <select name="barber_id" required class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] text-[#1d1d1f]">
          <option value="" disabled selected>Select barber</option>
          @foreach($barbers as $barber)
          <option value="{{ $barber->id }}" {{ old('barber_id') == $barber->id ? 'selected' : '' }}>
            {{ $barber->user->name }} — {{ $barber->specialty ?? 'Barber' }}
          </option>
          @endforeach
        </select>
      </div>

      {{-- Date --}}
      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Reservation Date</label>
        <input type="date" name="booking_date"
          value="{{ old('booking_date') }}"
          min="{{ date('Y-m-d') }}" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111]"
        />
      </div>

      {{-- Time --}}
      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Time</label>
        <input type="time" name="start_time"
          value="{{ old('start_time') }}"
          min="09:00" max="21:00" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111]"
        />
      </div>

    </div>

    {{-- Services --}}
    <div class="flex flex-col gap-2">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Choose Services <span class="text-[#aeaeb2] font-normal">(select one or more)</span></label>
      <div class="grid grid-cols-2 gap-3 max-sm:grid-cols-1">
        @foreach($services as $service)
        <label class="flex items-start gap-3 p-4 border border-[#d2d2d7] rounded-xl bg-white cursor-pointer transition-colors hover:border-[#111111] has-[:checked]:border-[#111111] has-[:checked]:bg-[#f5f5f7]">
          <input type="checkbox" name="service_ids[]" value="{{ $service->id }}"
            {{ in_array($service->id, old('service_ids', [])) ? 'checked' : '' }}
            class="mt-0.5 w-4 h-4 rounded accent-[#111111]" />
          <div class="flex flex-col gap-0.5">
            <span class="text-[0.9rem] font-semibold text-[#111111]">{{ $service->name }}</span>
            <span class="text-[0.78rem] text-[#6e6e73]">{{ $service->price_formatted }} · ± {{ $service->duration_minutes }} min</span>
          </div>
        </label>
        @endforeach
      </div>
    </div>

    {{-- Notes --}}
    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Note for the Barber <span class="text-[#aeaeb2] font-normal">(optional)</span></label>
      <textarea name="notes" rows="3"
        placeholder="Example: What hairstyle do you want?..."
        class="w-full px-4 py-3 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] resize-none placeholder:text-[#aeaeb2]">{{ old('notes') }}</textarea>
    </div>

    <div class="flex items-center gap-3 pt-2">
      <button type="submit"
        class="px-8 py-2.5 bg-[#111111] text-white text-[0.9rem] font-semibold rounded-full transition-opacity hover:opacity-80 cursor-pointer border-0">
        Make a Reservation
      </button>
      <button type="reset"
        class="px-6 py-2.5 border border-[#d2d2d7] text-[#6e6e73] text-[0.9rem] font-semibold rounded-full transition-colors hover:bg-[#f5f5f7] cursor-pointer bg-transparent">
        Reset
      </button>
    </div>
  </form>

</main>
@endsection
