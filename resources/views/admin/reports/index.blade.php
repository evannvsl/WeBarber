@extends('layouts.dashboard')
@section('title', 'Reports')
@section('page-title', 'Laporan & Statistik')

@section('content')

{{-- ─── Summary total ─── --}}
<div class="grid grid-cols-3 gap-4 mb-8 max-lg:grid-cols-3 max-sm:grid-cols-1">
  <div class="bg-[#0a0a0a] border border-[#0a0a0a] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-white/35 mb-1">Total Pendapatan (30 hari)</p>
    <p class="text-[1.35rem] font-extrabold text-white tracking-tight leading-none">
      Rp {{ number_format($dailyRevenue->sum('total_pendapatan'), 0, ',', '.') }}
    </p>
  </div>
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Hari dengan Transaksi</p>
    <p class="text-[2rem] font-extrabold text-[#111111] tracking-tight leading-none">{{ $dailyRevenue->count() }}</p>
  </div>
  <div class="bg-white border border-[#d2d2d7] rounded-2xl px-6 py-5 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <p class="text-[0.68rem] font-bold tracking-[0.2em] uppercase text-[#aeaeb2] mb-1">Rata-rata / Hari</p>
    <p class="text-[1.35rem] font-extrabold text-[#111111] tracking-tight leading-none">
      Rp {{ $dailyRevenue->count() > 0 ? number_format($dailyRevenue->sum('total_pendapatan') / $dailyRevenue->count(), 0, ',', '.') : '0' }}
    </p>
  </div>
</div>

<div class="grid grid-cols-2 gap-6 mb-6 max-lg:grid-cols-1">

  {{-- ─── Pendapatan Harian ─── --}}
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <div class="px-6 py-4 border-b border-[#f5f5f7] flex items-center justify-between">
      <div>
        <h3 class="text-[0.95rem] font-bold text-[#111111]">Pendapatan Harian</h3>
        <p class="text-[0.75rem] text-[#aeaeb2] mt-0.5">30 hari terakhir</p>
      </div>
      <span class="text-[0.72rem] font-bold text-[#aeaeb2] uppercase tracking-wider">{{ now()->format('M Y') }}</span>
    </div>
    <div class="divide-y divide-[#f5f5f7] max-h-80 overflow-y-auto">
      @forelse($dailyRevenue as $row)
      <div class="px-6 py-3 flex items-center justify-between gap-4">
        <span class="text-[0.82rem] text-[#6e6e73]">
          {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('D, d M Y') }}
        </span>
        <div class="flex items-center gap-3">
          {{-- Mini bar --}}
          @php $maxDaily = $dailyRevenue->max('total_pendapatan') ?: 1; @endphp
          <div class="w-20 h-2 bg-[#f5f5f7] rounded-full overflow-hidden">
            <div class="h-full bg-[#0a0a0a] rounded-full"
                 style="width: {{ round(($row->total_pendapatan / $maxDaily) * 100) }}%"></div>
          </div>
          <span class="text-[0.82rem] font-bold text-[#111111] text-right min-w-[100px]">
            Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}
          </span>
        </div>
      </div>
      @empty
      <p class="px-6 py-8 text-center text-[0.85rem] text-[#aeaeb2]">Belum ada data pendapatan.</p>
      @endforelse
    </div>
  </div>

  {{-- ─── Pendapatan Bulanan ─── --}}
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <div class="px-6 py-4 border-b border-[#f5f5f7]">
      <h3 class="text-[0.95rem] font-bold text-[#111111]">Pendapatan Bulanan</h3>
      <p class="text-[0.75rem] text-[#aeaeb2] mt-0.5">12 bulan terakhir</p>
    </div>
    <div class="divide-y divide-[#f5f5f7] max-h-80 overflow-y-auto">
      @forelse($monthlyRevenue as $row)
      @php $maxMonthly = $monthlyRevenue->max('total_pendapatan') ?: 1; @endphp
      <div class="px-6 py-3.5 flex items-center justify-between gap-4">
        <span class="text-[0.82rem] font-semibold text-[#3a3a3c]">
          {{ \Carbon\Carbon::createFromFormat('Y-m', $row->bulan)->translatedFormat('F Y') }}
        </span>
        <div class="flex items-center gap-3">
          <div class="w-24 h-2 bg-[#f5f5f7] rounded-full overflow-hidden">
            <div class="h-full bg-[#b8a060] rounded-full"
                 style="width: {{ round(($row->total_pendapatan / $maxMonthly) * 100) }}%"></div>
          </div>
          <span class="text-[0.85rem] font-bold text-[#111111] text-right min-w-[110px]">
            Rp {{ number_format($row->total_pendapatan, 0, ',', '.') }}
          </span>
        </div>
      </div>
      @empty
      <p class="px-6 py-8 text-center text-[0.85rem] text-[#aeaeb2]">Belum ada data pendapatan bulanan.</p>
      @endforelse
    </div>
  </div>

</div>

<div class="grid grid-cols-2 gap-6 max-lg:grid-cols-1">

  {{-- ─── Layanan Terpopuler ─── --}}
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <div class="px-6 py-4 border-b border-[#f5f5f7]">
      <h3 class="text-[0.95rem] font-bold text-[#111111]">Layanan Terpopuler</h3>
      <p class="text-[0.75rem] text-[#aeaeb2] mt-0.5">Berdasarkan booking confirmed & completed</p>
    </div>
    <div class="divide-y divide-[#f5f5f7]">
      @forelse($popularServices as $i => $service)
      @php $maxService = $popularServices->max('total_dipesan') ?: 1; @endphp
      <div class="px-6 py-4">
        <div class="flex items-center justify-between mb-1.5">
          <div class="flex items-center gap-3">
            <span class="text-[0.72rem] font-bold text-[#aeaeb2] w-5 shrink-0">{{ $i + 1 }}</span>
            <span class="text-[0.88rem] font-semibold text-[#111111]">{{ $service->nama_layanan }}</span>
          </div>
          <span class="text-[0.82rem] font-bold text-[#b8a060]">{{ $service->total_dipesan }}×</span>
        </div>
        <div class="ml-8 h-1.5 bg-[#f5f5f7] rounded-full overflow-hidden">
          <div class="h-full bg-[#b8a060] rounded-full transition-all"
               style="width: {{ round(($service->total_dipesan / $maxService) * 100) }}%"></div>
        </div>
      </div>
      @empty
      <p class="px-6 py-8 text-center text-[0.85rem] text-[#aeaeb2]">Belum ada data layanan.</p>
      @endforelse
    </div>
  </div>

  {{-- ─── Barber Terbaik ─── --}}
  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <div class="px-6 py-4 border-b border-[#f5f5f7]">
      <h3 class="text-[0.95rem] font-bold text-[#111111]">Barber Terbaik</h3>
      <p class="text-[0.75rem] text-[#aeaeb2] mt-0.5">Berdasarkan jumlah booking selesai</p>
    </div>
    <div class="divide-y divide-[#f5f5f7]">
      @forelse($topBarbers as $i => $barber)
      @php $maxBarber = $topBarbers->max('total_pelayanan') ?: 1; @endphp
      <div class="px-6 py-4">
        <div class="flex items-center justify-between mb-1.5">
          <div class="flex items-center gap-3">
            {{-- Rank badge --}}
            <span class="w-6 h-6 rounded-full flex items-center justify-center text-[0.65rem] font-extrabold shrink-0
              {{ $i === 0 ? 'bg-amber-400 text-white' : ($i === 1 ? 'bg-slate-300 text-white' : ($i === 2 ? 'bg-orange-300 text-white' : 'bg-[#f5f5f7] text-[#aeaeb2]')) }}">
              {{ $i + 1 }}
            </span>
            <div>
              <p class="text-[0.88rem] font-semibold text-[#111111]">{{ $barber->name }}</p>
            </div>
          </div>
          <span class="text-[0.82rem] font-bold text-[#111111]">{{ $barber->total_pelayanan }} <span class="font-normal text-[#aeaeb2]">sesi</span></span>
        </div>
        <div class="ml-9 h-1.5 bg-[#f5f5f7] rounded-full overflow-hidden">
          <div class="h-full bg-[#0a0a0a] rounded-full transition-all"
               style="width: {{ round(($barber->total_pelayanan / $maxBarber) * 100) }}%"></div>
        </div>
      </div>
      @empty
      <p class="px-6 py-8 text-center text-[0.85rem] text-[#aeaeb2]">Belum ada data barber.</p>
      @endforelse
    </div>
  </div>

</div>

@endsection
