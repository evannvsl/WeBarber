@extends('layouts.dashboard')
@section('title', 'Services')
@section('page-title', 'Manage Services')

@section('content')
<div class="flex items-center justify-between mb-6">
  <p class="text-[0.85rem] text-[#6e6e73]">{{ $grouped->flatten()->count() }} services in {{ $grouped->count() }} categories</p>
  <a href="{{ route('admin.services.create') }}" class="px-5 py-2 bg-[#111111] text-white text-[0.82rem] font-semibold rounded-full no-underline hover:opacity-75">
    + Add Service
  </a>
</div>

@forelse($grouped as $category => $services)
<div class="mb-8">

  {{-- Category header --}}
  <div class="flex items-center gap-3 mb-3">
    <h3 class="text-[0.95rem] font-bold text-[#111111]">{{ $category }}</h3>
    <span class="text-[0.7rem] font-semibold text-[#aeaeb2] bg-[#f5f5f7] border border-[#e8e8ed] px-2 py-0.5 rounded-full">
      {{ $services->count() }} services
    </span>
  </div>

  <div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    <table class="w-full border-collapse text-[0.88rem]">
      <thead class="bg-[#f5f5f7]">
        <tr>
          <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Service</th>
          <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Price</th>
          <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Duration</th>
          <th class="text-left px-5 py-3 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Status</th>
          <th class="px-5 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-[#f5f5f7]">
        @foreach($services as $service)
        <tr class="hover:bg-[#f5f5f7] transition-colors">
          <td class="px-5 py-3.5">
            <p class="font-semibold text-[#111111]">{{ $service->name }}</p>
            @if($service->description)
            <p class="text-[0.75rem] text-[#aeaeb2] mt-0.5">{{ Str::limit($service->description, 60) }}</p>
            @endif
          </td>
          <td class="px-5 py-3.5 font-semibold text-[#111111]">{{ $service->price_formatted }}</td>
          <td class="px-5 py-3.5 text-[#6e6e73]">{{ $service->duration_minutes }} min</td>
          <td class="px-5 py-3.5">
            <span class="inline-block text-[0.68rem] font-bold tracking-[0.06em] uppercase px-2 py-0.5 rounded-full border
              {{ $service->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-[#f5f5f7] text-[#aeaeb2] border-[#d2d2d7]' }}">
              {{ $service->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td class="px-5 py-3.5">
            <div class="flex items-center gap-3 justify-end">
              <a href="{{ route('admin.services.edit', $service) }}"
                class="text-[0.78rem] font-semibold text-[#111111] no-underline hover:opacity-60">Edit</a>
              <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                onsubmit="return confirm('{{ $service->bookingDetails()->exists() ? 'Service ini sudah pernah digunakan. Lanjutkan? Service akan dinonaktifkan.' : 'Hapus service ini?' }}')">
                @csrf @method('DELETE')
                <button type="submit"
                  class="text-[0.78rem] font-semibold bg-transparent border-0 cursor-pointer hover:opacity-60
                    {{ $service->bookingDetails()->exists() ? 'text-amber-600' : 'text-red-600' }}">
                  {{ $service->bookingDetails()->exists() ? 'Deactivate' : 'Delete' }}
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@empty
<div class="text-center py-16 border border-[#d2d2d7] rounded-2xl bg-white">
  <p class="text-[0.9rem] text-[#6e6e73] mb-3">No services yet.</p>
  <a href="{{ route('admin.services.create') }}" class="text-[0.85rem] font-semibold text-[#111111] underline">Add your first service</a>
</div>
@endforelse
@endsection
