@extends('layouts.dashboard')
@section('title', 'Barber Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-4 gap-4 mb-8 max-lg:grid-cols-2 max-sm:grid-cols-1">
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Today</p>
    <p class="text-[2.2rem] font-extrabold text-[#111111] tracking-tight leading-none">{{ $stats['today'] }}</p>
  </div>
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Pending</p>
    <p class="text-[2.2rem] font-extrabold text-[#111111] tracking-tight leading-none">{{ $stats['pending'] }}</p>
  </div>
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Completed</p>
    <p class="text-[2.2rem] font-extrabold text-[#111111] tracking-tight leading-none">{{ $stats['completed'] }}</p>
  </div>
  <div class="bg-[#0a0a0a] border border-[#0a0a0a] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-white/35 mb-1">Total</p>
    <p class="text-[2.2rem] font-extrabold text-white tracking-tight leading-none">{{ $stats['total'] }}</p>
  </div>
</div>

{{-- Today's Bookings --}}
<div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
  <div class="px-6 py-4 border-b border-[#f5f5f7] flex items-center justify-between">
    <h3 class="text-[0.95rem] font-bold text-[#111111]">Today's Bookings</h3>
    <a href="{{ route('barber.bookings') }}" class="text-[0.75rem] text-[#6e6e73] no-underline hover:text-[#111111]">View all →</a>
  </div>
  <div class="divide-y divide-[#f5f5f7]">
    @forelse($todayBookings as $booking)
    <div class="px-6 py-4 flex items-start justify-between gap-4">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-[#f5f5f7] border border-[#d2d2d7] flex items-center justify-center text-[0.85rem] font-bold text-[#3a3a3c] shrink-0">
          {{ strtoupper(substr($booking->user?->name ?? '|', 0, 1)) }}
        </div>
        <div>
          <p class="text-[0.88rem] font-semibold text-[#111111]">{{ $booking->user?->name ?? '|' }}</p>
          <p class="text-[0.75rem] text-[#6e6e73]">{{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}</p>
          <div class="flex flex-wrap gap-1 mt-1">
            @foreach($booking->details as $detail)
            <span class="text-[0.68rem] font-medium text-[#6e6e73] bg-[#f5f5f7] rounded px-1.5 py-0.5">{{ $detail->service?->name ?? '|' }}</span>
            @endforeach
          </div>
        </div>
      </div>
      <span class="inline-block shrink-0 text-[0.68rem] font-bold tracking-[0.06em] uppercase px-2 py-0.5 rounded-full border {{ \App\Models\Booking::$statusColors[$booking->status] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
        {{ ucfirst($booking->status) }}
      </span>
    </div>
    @empty
    <p class="px-6 py-8 text-center text-[0.85rem] text-[#6e6e73]">No bookings scheduled for today.</p>
    @endforelse
  </div>
</div>

@endsection
