@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats grid --}}
<div class="grid grid-cols-4 gap-4 mb-8 max-lg:grid-cols-2 max-sm:grid-cols-1">
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Customers</p>
    <p class="text-[2.2rem] font-extrabold text-[#111111] tracking-tight leading-none">{{ number_format($stats['total_customers']) }}</p>
  </div>
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Active Barbers</p>
    <p class="text-[2.2rem] font-extrabold text-[#111111] tracking-tight leading-none">{{ number_format($stats['total_barbers']) }}</p>
  </div>
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Total Bookings</p>
    <p class="text-[2.2rem] font-extrabold text-[#111111] tracking-tight leading-none">{{ number_format($stats['total_bookings']) }}</p>
  </div>
  <div class="bg-[#0a0a0a] border border-[#0a0a0a] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-white/35 mb-1">Revenue</p>
    <p class="text-[1.5rem] font-extrabold text-white tracking-tight leading-none">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
  </div>
</div>

<div class="grid grid-cols-2 gap-6 max-lg:grid-cols-1">

  {{-- Recent Bookings --}}
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <div class="px-6 py-4 border-b border-[#f5f5f7] flex items-center justify-between">
      <h3 class="text-[0.95rem] font-bold text-[#111111]">Recent Bookings</h3>
      <a href="{{ route('admin.bookings.index') }}" class="text-[0.75rem] text-[#6e6e73] no-underline hover:text-[#111111]">View all →</a>
    </div>
    <div class="divide-y divide-[#f5f5f7]">
      @forelse($recentBookings as $booking)
      <div class="px-6 py-3.5 flex items-center justify-between gap-3">
        <div>
          <p class="text-[0.85rem] font-semibold text-[#111111]">{{ $booking->user->name }}</p>
          <p class="text-[0.75rem] text-[#6e6e73]">{{ $booking->booking_date->format('d M Y') }} · {{ $booking->barber->user->name }}</p>
        </div>
        <span class="inline-block text-[0.68rem] font-bold tracking-[0.06em] uppercase px-2 py-0.5 rounded-full border {{ \App\Models\Booking::$statusColors[$booking->status] }}">
          {{ ucfirst($booking->status) }}
        </span>
      </div>
      @empty
      <p class="px-6 py-4 text-[0.85rem] text-[#6e6e73]">No bookings yet.</p>
      @endforelse
    </div>
  </div>

  {{-- Popular Services --}}
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <div class="px-6 py-4 border-b border-[#f5f5f7]">
      <h3 class="text-[0.95rem] font-bold text-[#111111]">Popular Services</h3>
    </div>
    <div class="divide-y divide-[#f5f5f7]">
      @forelse($popularServices as $i => $service)
      <div class="px-6 py-3.5 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
          <span class="text-[0.68rem] font-bold text-[#aeaeb2] w-4">{{ $i + 1 }}</span>
          <span class="text-[0.85rem] font-semibold text-[#111111]">{{ $service->nama_layanan }}</span>
        </div>
        <span class="text-[0.78rem] font-bold text-[#b8a060]">{{ $service->total_dipesan }}×</span>
      </div>
      @empty
      <p class="px-6 py-4 text-[0.85rem] text-[#6e6e73]">No data yet.</p>
      @endforelse
    </div>
  </div>

</div>
@endsection
