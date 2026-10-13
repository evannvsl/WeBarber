@extends('layouts.dashboard')
@section('title', 'Edit Service')
@section('page-title', 'Edit Service')

@section('content')
<div class="max-w-lg">
  <form method="POST" action="{{ route('admin.services.update', $service) }}" class="bg-white border border-[#d2d2d7] rounded-2xl p-8 flex flex-col gap-4 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    @csrf @method('PUT')

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Service Name</label>
      <input type="text" name="name" value="{{ old('name', $service->name) }}" required
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]" />
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Description</label>
      <textarea name="description" rows="3"
        class="w-full px-4 py-3 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111] resize-none">{{ old('description', $service->description) }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Price (Rp)</label>
        <input type="number" name="price" value="{{ old('price', $service->price) }}" min="0" step="1000" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]" />
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Duration (min)</label>
        <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" min="5" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]" />
      </div>
    </div>

    <label class="flex items-center gap-2 cursor-pointer">
      <input type="checkbox" name="is_active" {{ old('is_active', $service->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded" />
      <span class="text-[0.85rem] text-[#3a3a3c]">Active</span>
    </label>

    <div class="flex items-center gap-3 pt-2">
      <button type="submit" class="px-6 py-2.5 bg-[#111111] text-white text-[0.88rem] font-semibold rounded-full hover:opacity-80 cursor-pointer border-0">Update</button>
      <a href="{{ route('admin.services.index') }}" class="px-6 py-2.5 border border-[#d2d2d7] text-[#6e6e73] text-[0.88rem] font-semibold rounded-full no-underline hover:bg-[#f5f5f7]">Cancel</a>
    </div>
  </form>
</div>
@endsection
