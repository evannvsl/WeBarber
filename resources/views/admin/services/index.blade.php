@extends('layouts.dashboard')
@section('title', 'Services')
@section('page-title', 'Manage Services')

@section('content')
<div class="flex items-center justify-between mb-6">
  <p class="text-[0.85rem] text-[#6e6e73]">{{ $services->total() }} services</p>
  <a href="{{ route('admin.services.create') }}" class="px-5 py-2 bg-[#111111] text-white text-[0.82rem] font-semibold rounded-full no-underline hover:opacity-75">
    + Add Service
  </a>
</div>

<div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
  <table class="w-full border-collapse text-[0.88rem]">
    <thead class="bg-[#f5f5f7]">
      <tr>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Service</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Price</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Duration</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Status</th>
        <th class="px-5 py-3.5"></th>
      </tr>
    </thead>
    <tbody class="divide-y divide-[#f5f5f7]">
      @forelse($services as $service)
      <tr class="hover:bg-[#f5f5f7] transition-colors">
        <td class="px-5 py-3.5 font-medium text-[#111111]">{{ $service->name }}</td>
        <td class="px-5 py-3.5 font-semibold text-[#111111]">{{ $service->price_formatted }}</td>
        <td class="px-5 py-3.5 text-[#6e6e73]">{{ $service->duration_minutes }} min</td>
        <td class="px-5 py-3.5">
          <span class="inline-block text-[0.68rem] font-bold tracking-[0.06em] uppercase px-2 py-0.5 rounded-full border {{ $service->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-[#f5f5f7] text-[#aeaeb2] border-[#d2d2d7]' }}">
            {{ $service->is_active ? 'Active' : 'Inactive' }}
          </span>
        </td>
        <td class="px-5 py-3.5">
          <div class="flex items-center gap-3 justify-end">
            <a href="{{ route('admin.services.edit', $service) }}" class="text-[0.78rem] font-semibold text-[#111111] no-underline hover:opacity-60">Edit</a>
            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-[0.78rem] font-semibold text-red-600 bg-transparent border-0 cursor-pointer hover:opacity-60">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-5 py-8 text-center text-[#6e6e73] text-[0.85rem]">No services found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $services->links() }}</div>
@endsection
