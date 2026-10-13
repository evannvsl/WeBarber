@extends('layouts.dashboard')
@section('title', 'Booking Detail')
@section('page-title', 'Booking #' . $booking->id)

@section('content')
<div class="max-w-2xl">

  <div class="grid grid-cols-2 gap-6 mb-6 max-sm:grid-cols-1">
    {{-- Customer info --}}
    <div class="bg-white border border-[#d2d2d7] rounded-2xl p-6 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
      <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-3">Customer</p>
      <p class="text-[0.95rem] font-bold text-[#111111]">{{ $booking->user->name }}</p>
      <p class="text-[0.82rem] text-[#6e6e73]">{{ $booking->user->email }}</p>
      <p class="text-[0.82rem] text-[#6e6e73]">{{ $booking->user->phone ?? '—' }}</p>
    </div>
    {{-- Booking info --}}
    <div class="bg-white border border-[#d2d2d7] rounded-2xl p-6 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
      <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-3">Booking</p>
      <p class="text-[0.95rem] font-bold text-[#111111]">{{ $booking->barber->user->name }}</p>
      <p class="text-[0.82rem] text-[#6e6e73]">{{ $booking->booking_date->format('D, d M Y') }}</p>
      <p class="text-[0.82rem] text-[#6e6e73]">{{ substr($booking->start_time, 0, 5) }} – {{ substr($booking->end_time, 0, 5) }}</p>
      <span class="inline-block mt-2 text-[0.68rem] font-bold tracking-[0.06em] uppercase px-2 py-0.5 rounded-full border {{ \App\Models\Booking::$statusColors[$booking->status] }}">
        {{ ucfirst($booking->status) }}
      </span>
    </div>
  </div>

  {{-- Services --}}
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)] mb-6">
    <div class="px-6 py-4 border-b border-[#f5f5f7]">
      <h3 class="text-[0.9rem] font-bold text-[#111111]">Services</h3>
    </div>
    <div class="divide-y divide-[#f5f5f7]">
      @foreach($booking->details as $detail)
      <div class="px-6 py-3.5 flex justify-between text-[0.88rem]">
        <span class="text-[#3a3a3c]">{{ $detail->service->name ?? 'Removed service' }}</span>
        <span class="font-semibold text-[#111111]">Rp {{ number_format($detail->price, 0, ',', '.') }}</span>
      </div>
      @endforeach
      <div class="px-6 py-3.5 flex justify-between bg-[#f5f5f7]">
        <span class="text-[0.88rem] font-bold text-[#111111]">Total</span>
        <span class="text-[0.88rem] font-bold text-[#111111]">Rp {{ number_format($booking->total, 0, ',', '.') }}</span>
      </div>
    </div>
  </div>

  {{-- Payments --}}
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)] mb-6">
    <div class="px-6 py-4 border-b border-[#f5f5f7]">
      <h3 class="text-[0.9rem] font-bold text-[#111111]">Payments</h3>
    </div>
    @forelse($booking->payments as $payment)
    <div class="px-6 py-3.5 flex justify-between items-center text-[0.85rem]">
      <div>
        <span class="font-semibold text-[#111111]">{{ $payment->amount_formatted }}</span>
        <span class="text-[#aeaeb2] ml-2">via {{ strtoupper($payment->payment_method) }}</span>
      </div>
      <span class="inline-block text-[0.68rem] font-bold uppercase px-2 py-0.5 rounded-full border
        {{ $payment->payment_status === 'paid' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
        {{ ucfirst($payment->payment_status) }}
      </span>
    </div>
    @empty
    <p class="px-6 py-4 text-[0.85rem] text-[#6e6e73]">No payment recorded.</p>
    @endforelse

    {{-- Record new payment --}}
    <div class="px-6 py-4 bg-[#f5f5f7] border-t border-[#e8e8ed]">
      <form method="POST" action="{{ route('admin.payments.store') }}" class="flex items-end gap-3 flex-wrap">
        @csrf
        <input type="hidden" name="booking_id" value="{{ $booking->id }}" />
        <div class="flex flex-col gap-1">
          <label class="text-[0.72rem] font-semibold text-[#6e6e73]">Amount (Rp)</label>
          <input type="number" name="amount" value="{{ $booking->total }}" min="0"
            class="px-3 py-2 text-[0.85rem] border border-[#d2d2d7] rounded-lg bg-white outline-none focus:border-[#111111] w-36" />
        </div>
        <div class="flex flex-col gap-1">
          <label class="text-[0.72rem] font-semibold text-[#6e6e73]">Method</label>
          <select name="payment_method" class="px-3 py-2 text-[0.85rem] border border-[#d2d2d7] rounded-lg bg-white outline-none">
            <option value="cash">Cash</option>
            <option value="transfer">Transfer</option>
            <option value="qris">QRIS</option>
          </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-[#111111] text-white text-[0.82rem] font-semibold rounded-lg hover:opacity-80 cursor-pointer border-0">
          Record Payment
        </button>
      </form>
    </div>
  </div>

  @if($booking->notes)
  <div class="bg-white border border-[#d2d2d7] rounded-2xl p-6 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-2">Customer Notes</p>
    <p class="text-[0.88rem] text-[#3a3a3c] italic">"{{ $booking->notes }}"</p>
  </div>
  @endif

  <div class="mt-6">
    <a href="{{ route('admin.bookings.index') }}" class="text-[0.82rem] font-semibold text-[#6e6e73] no-underline hover:text-[#111111]">← Back to bookings</a>
  </div>
</div>
@endsection
