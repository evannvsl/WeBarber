@extends('layouts.dashboard')
@section('title', 'Add Service')
@section('page-title', 'Add New Service')

@section('content')
<div class="max-w-lg">
  <form method="POST" action="{{ route('admin.services.store') }}"
    class="bg-white border border-[#d2d2d7] rounded-2xl p-8 flex flex-col gap-4 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    @csrf

    {{-- Category --}}
    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Category</label>
      <select name="category" required
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]">
        @foreach($categories as $cat)
        <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
    </div>

    {{-- Name --}}
    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Service Name</label>
      <input type="text" name="name" value="{{ old('name') }}" required
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]"
        placeholder="e.g. Classic Fade" />
    </div>

    {{-- Description --}}
    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Description <span class="font-normal text-[#aeaeb2]">(optional)</span></label>
      <textarea name="description" rows="3"
        class="w-full px-4 py-3 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111] resize-none"
        placeholder="Brief description of the service...">{{ old('description') }}</textarea>
    </div>

    {{-- Price & Duration --}}
    <div class="grid grid-cols-2 gap-4">
      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Price (Rp)</label>
        <input type="number" name="price" value="{{ old('price') }}" min="0" step="1000" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]"
          placeholder="50000" />
      </div>
      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Duration (min)</label>
        <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" min="5" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]"
          placeholder="30" />
      </div>
    </div>

    {{-- Active --}}
    <label class="flex items-center gap-2 cursor-pointer">
      <input type="checkbox" name="is_active" checked class="w-4 h-4 rounded" />
      <span class="text-[0.85rem] text-[#3a3a3c]">Active (visible to customers)</span>
    </label>

    <div class="flex items-center gap-3 pt-2">
      <button type="submit"
        class="px-6 py-2.5 bg-[#111111] text-white text-[0.88rem] font-semibold rounded-full hover:opacity-80 cursor-pointer border-0">
        Save Service
      </button>
      <a href="{{ route('admin.services.index') }}"
        class="px-6 py-2.5 border border-[#d2d2d7] text-[#6e6e73] text-[0.88rem] font-semibold rounded-full no-underline hover:bg-[#f5f5f7]">
        Cancel
      </a>
    </div>
  </form>
</div>
@endsection
