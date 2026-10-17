@extends('layouts.app')
@section('title', 'WeBarber | My Bookings')

@section('content')

<section class="bg-[#f5f5f7] border-b border-[#d2d2d7] py-14 px-8 text-center">
  <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-2">Account</p>
  <h2 class="text-[clamp(1.8rem,4vw,2.8rem)] font-extrabold tracking-[-1px] text-[#111111] leading-none">Booking History</h2>
</section>

<main class="max-w-[900px] mx-auto px-6 pb-24 pt-12">

  @if(session('success'))
  <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-[0.85rem] text-green-800">
    <span>✓</span> {{ session('success') }}
  </div>
  @endif

  <div class="flex items-center justify-between mb-8">
    <h3 class="text-[1.2rem] font-bold text-[#111111] tracking-tight">Your Bookings</h3>
    <a href="{{ route('customer.booking') }}" class="px-5 py-2 bg-[#111111] text-white text-[0.82rem] font-semibold rounded-full no-underline transition-opacity hover:opacity-75">
      + New Booking
    </a>
  </div>

  @if($bookings->isEmpty())
  <div class="text-center py-20 border border-[#d2d2d7] rounded-2xl bg-[#f5f5f7]">
    <p class="text-[1rem] text-[#6e6e73] mb-4">You haven't made any bookings yet.</p>
    <a href="{{ route('customer.booking') }}" class="inline-flex items-center gap-1.5 text-[0.85rem] font-semibold text-[#111111] no-underline border-b border-[#111111] pb-px">
      Book your first session →
    </a>
  </div>
  @else

  <div class="flex flex-col gap-4">
    @foreach($bookings as $booking)
    <div class="border border-[#d2d2d7] rounded-2xl bg-white overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
      {{-- Header --}}
      <div class="px-6 py-4 border-b border-[#f5f5f7] flex items-center justify-between gap-4 flex-wrap">
        <div class="flex items-center gap-4">
          <div class="w-10 h-10 rounded-full bg-[#f5f5f7] border border-[#d2d2d7] flex items-center justify-center text-[0.9rem] font-bold text-[#3a3a3c]">
            {{ strtoupper(substr($booking->barber->user->name, 0, 1)) }}
          </div>
          <div>
            <p class="text-[0.95rem] font-bold text-[#111111]">{{ $booking->barber->user->name }}</p>
            <p class="text-[0.75rem] text-[#6e6e73]">
              {{ $booking->booking_date->format('D, d M Y') }} · {{ substr($booking->start_time, 0, 5) }}–{{ substr($booking->end_time, 0, 5) }}
            </p>
          </div>
        </div>
        <span class="inline-block text-[0.72rem] font-bold tracking-[0.06em] uppercase px-2.5 py-0.5 rounded-full border {{ \App\Models\Booking::$statusColors[$booking->status] }}">
          {{ ucfirst($booking->status) }}
        </span>
      </div>

      {{-- Services --}}
      <div class="px-6 py-4">
        <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-2">Services</p>
        <div class="flex flex-col gap-1.5">
          @foreach($booking->details as $detail)
          <div class="flex justify-between text-[0.85rem]">
            <span class="text-[#3a3a3c]">{{ $detail->service->name ?? 'Service removed' }}</span>
            <span class="text-[#6e6e73]">{{ 'Rp ' . number_format($detail->price, 0, ',', '.') }}</span>
          </div>
          @endforeach
        </div>
        <div class="mt-3 pt-3 border-t border-[#f5f5f7] flex justify-between">
          <span class="text-[0.85rem] font-semibold text-[#111111]">Total</span>
          <span class="text-[0.85rem] font-bold text-[#111111]">Rp {{ number_format($booking->total, 0, ',', '.') }}</span>
        </div>
      </div>

      @if($booking->notes)
      <div class="px-6 pb-4">
        <p class="text-[0.75rem] text-[#aeaeb2] italic">"{{ $booking->notes }}"</p>
      </div>
      @endif

      {{-- Actions --}}
      @if($booking->status === 'pending')
      <div class="px-6 pb-4">
        <form method="POST" action="{{ route('customer.booking.cancel', $booking) }}"
          onsubmit="return confirm('Cancel this booking?')">
          @csrf
          <button type="submit"
            class="text-[0.78rem] font-semibold text-red-600 border-b border-red-300 pb-px bg-transparent border-t-0 border-l-0 border-r-0 cursor-pointer transition-opacity hover:opacity-65">
            Cancel booking
          </button>
        </form>
      </div>
      @endif

    </div>
    @endforeach
  </div>

  <div class="mt-8">
    {{ $bookings->links() }}
  </div>

  @endif
</main>
@endsection
