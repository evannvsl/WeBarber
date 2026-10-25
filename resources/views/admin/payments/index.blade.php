@extends('layouts.dashboard')
@section('title', 'Payments')
@section('page-title', 'Manage Payments')

@section('content')

{{-- Summary stats --}}
<div class="grid grid-cols-4 gap-4 mb-8 max-lg:grid-cols-2 max-sm:grid-cols-1">
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Total Transaksi</p>
    <p class="text-[2rem] font-extrabold text-[#111111] tracking-tight leading-none">{{ number_format($stats['total']) }}</p>
  </div>
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Sudah Dibayar</p>
    <p class="text-[2rem] font-extrabold text-green-600 tracking-tight leading-none">{{ number_format($stats['paid']) }}</p>
  </div>
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Pending</p>
    <p class="text-[2rem] font-extrabold text-amber-500 tracking-tight leading-none">{{ number_format($stats['pending']) }}</p>
  </div>
  <div class="bg-[#0a0a0a] border border-[#0a0a0a] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-white/35 mb-1">Total Revenue</p>
    <p class="text-[1.2rem] font-extrabold text-white tracking-tight leading-none">
      Rp {{ number_format($stats['revenue'], 0, ',', '.') }}
    </p>
  </div>
</div>

{{-- Tabel payments --}}
<div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
  <div class="px-6 py-4 border-b border-[#f5f5f7]">
    <h3 class="text-[0.95rem] font-bold text-[#111111]">Semua Pembayaran</h3>
    <p class="text-[0.78rem] text-[#aeaeb2] mt-0.5">Pencatatan pembayaran dapat dilakukan melalui halaman detail booking.</p>
  </div>

  <table class="w-full border-collapse text-[0.85rem]">
    <thead class="bg-[#f5f5f7]">
      <tr>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">#</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Customer</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Booking ID</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Jumlah</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Metode</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Status</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Waktu Bayar</th>
        <th class="px-5 py-3.5"></th>
      </tr>
    </thead>
    <tbody class="divide-y divide-[#f5f5f7]">
      @forelse($payments as $payment)
      <tr class="hover:bg-[#f5f5f7] transition-colors">
        <td class="px-5 py-3.5 text-[#aeaeb2] font-mono text-[0.78rem]">#{{ $payment->id }}</td>
        <td class="px-5 py-3.5">
          <p class="font-semibold text-[#111111]">{{ $payment->booking->user->name }}</p>
          <p class="text-[0.75rem] text-[#aeaeb2]">{{ $payment->booking->user->email }}</p>
        </td>
        <td class="px-5 py-3.5">
          <a href="{{ route('admin.bookings.show', $payment->booking_id) }}"
             class="text-[0.82rem] font-semibold text-[#111111] no-underline hover:opacity-60">
            #{{ $payment->booking_id }}
          </a>
        </td>
        <td class="px-5 py-3.5 font-bold text-[#111111]">
          Rp {{ number_format($payment->amount, 0, ',', '.') }}
        </td>
        <td class="px-5 py-3.5">
          <span class="inline-block text-[0.68rem] font-bold tracking-[0.06em] uppercase px-2 py-0.5 rounded-full border
            @if($payment->payment_method === 'cash') bg-slate-50 text-slate-600 border-slate-200
            @elseif($payment->payment_method === 'transfer') bg-blue-50 text-blue-700 border-blue-200
            @else bg-purple-50 text-purple-700 border-purple-200
            @endif">
            {{ strtoupper($payment->payment_method) }}
          </span>
        </td>
        <td class="px-5 py-3.5">
          {{-- Dropdown ubah status --}}
          <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
            @csrf @method('PUT')
            <select name="payment_status" onchange="this.form.submit()"
              class="px-2 py-1 text-[0.75rem] border border-[#d2d2d7] rounded-lg bg-white outline-none focus:border-[#111111] cursor-pointer
                @if($payment->payment_status === 'paid') text-green-700
                @elseif($payment->payment_status === 'pending') text-amber-600
                @elseif($payment->payment_status === 'failed') text-red-600
                @else text-slate-500
                @endif">
              @foreach(['pending','paid','failed','refunded'] as $s)
                <option value="{{ $s }}" {{ $payment->payment_status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </form>
        </td>
        <td class="px-5 py-3.5 text-[#6e6e73] text-[0.8rem]">
          {{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : '—' }}
        </td>
        <td class="px-5 py-3.5 text-right">
          <a href="{{ route('admin.bookings.show', $payment->booking_id) }}"
             class="text-[0.78rem] font-semibold text-[#111111] no-underline hover:opacity-60">
            Lihat →
          </a>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="8" class="px-5 py-12 text-center text-[#aeaeb2] text-[0.88rem]">
          Belum ada pembayaran tercatat.
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-4">{{ $payments->links() }}</div>

@endsection
