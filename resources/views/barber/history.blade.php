@extends('layouts.dashboard')
@section('title', 'Service History')
@section('page-title', 'Service History')

@section('content')
<div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
  <table class="w-full border-collapse text-[0.85rem]">
    <thead class="bg-[#f5f5f7]">
      <tr>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">#</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Customer</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Date</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Services</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Total</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-[#f5f5f7]">
      @forelse($history as $booking)
      <tr class="hover:bg-[#f5f5f7] transition-colors">
        <td class="px-5 py-3.5 text-[#aeaeb2] font-mono text-[0.78rem]">#{{ $booking->id }}</td>
        <td class="px-5 py-3.5 font-medium text-[#111111]">{{ $booking->user?->name ?? '|' }}</td>
        <td class="px-5 py-3.5 text-[#6e6e73]">{{ $booking->booking_date?->format('d M Y') }} · {{ substr($booking->start_time, 0, 5) }}</td>
        <td class="px-5 py-3.5 text-[#6e6e73]">
          {{ $booking->details->map(fn($d) => $d->service?->name)->filter()->implode(', ') ?: '|' }}
        </td>
        <td class="px-5 py-3.5 font-semibold text-[#111111]">Rp {{ number_format($booking->total, 0, ',', '.') }}</td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-5 py-8 text-center text-[#6e6e73] text-[0.85rem]">No completed bookings yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $history->links() }}</div>
@endsection
