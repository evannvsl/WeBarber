@extends('layouts.dashboard')
@section('title', 'Bookings')
@section('page-title', 'Manage Bookings')

@section('content')
<div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
  <table class="w-full border-collapse text-[0.85rem]">
    <thead class="bg-[#f5f5f7]">
      <tr>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">#</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Customer</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Barber</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Date</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Status</th>
        <th class="px-5 py-3.5"></th>
      </tr>
    </thead>
    <tbody class="divide-y divide-[#f5f5f7]">
      @forelse($bookings as $booking)
      <tr class="hover:bg-[#f5f5f7] transition-colors">
        <td class="px-5 py-3.5 text-[#aeaeb2] font-mono text-[0.78rem]">#{{ $booking->id }}</td>
        <td class="px-5 py-3.5 font-medium text-[#111111]">{{ $booking->user->name }}</td>
        <td class="px-5 py-3.5 text-[#6e6e73]">{{ $booking->barber->user->name }}</td>
        <td class="px-5 py-3.5 text-[#6e6e73]">{{ $booking->booking_date->format('d M Y') }} {{ substr($booking->start_time, 0, 5) }}</td>
        <td class="px-5 py-3.5">
          <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="flex items-center gap-2">
            @csrf @method('PUT')
            <select name="status" onchange="this.form.submit()"
              class="px-2 py-1 text-[0.75rem] border border-[#d2d2d7] rounded-lg bg-white outline-none focus:border-[#111111] cursor-pointer">
              @foreach(['pending','confirmed','completed','cancelled'] as $s)
              <option value="{{ $s }}" {{ $booking->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </form>
        </td>
        <td class="px-5 py-3.5 text-right">
          <a href="{{ route('admin.bookings.show', $booking) }}" class="text-[0.78rem] font-semibold text-[#111111] no-underline hover:opacity-60">View</a>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" class="px-5 py-8 text-center text-[#6e6e73] text-[0.85rem]">No bookings yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $bookings->links() }}</div>
@endsection
