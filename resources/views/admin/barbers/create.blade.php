@extends('layouts.dashboard')
@section('title', 'Add Barber')
@section('page-title', 'Add Barber Profile')

@section('content')
<div class="max-w-lg">
  <form method="POST" action="{{ route('admin.barbers.store') }}" class="bg-white border border-[#d2d2d7] rounded-2xl p-8 flex flex-col gap-4 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    @csrf

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">User (Barber role)</label>
      <select name="user_id" required class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]">
        <option value="" disabled selected>Select user</option>
        @foreach($users as $user)
        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
        @endforeach
      </select>
      @if($users->isEmpty())
      <p class="text-[0.78rem] text-amber-700">No users with 'barber' role available. <a href="{{ route('admin.users.create') }}" class="font-semibold underline">Create one first.</a></p>
      @endif
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Specialty</label>
      <input type="text" name="specialty" value="{{ old('specialty') }}" placeholder="e.g. Fade Specialist"
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111] placeholder:text-[#aeaeb2]" />
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Bio</label>
      <textarea name="bio" rows="3"
        class="w-full px-4 py-3 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111] resize-none">{{ old('bio') }}</textarea>
    </div>

    <label class="flex items-center gap-2 cursor-pointer">
      <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="w-4 h-4 rounded" />
      <span class="text-[0.85rem] text-[#3a3a3c]">Active</span>
    </label>

    <div class="flex items-center gap-3 pt-2">
      <button type="submit" class="px-6 py-2.5 bg-[#111111] text-white text-[0.88rem] font-semibold rounded-full hover:opacity-80 cursor-pointer border-0">Save</button>
      <a href="{{ route('admin.barbers.index') }}" class="px-6 py-2.5 border border-[#d2d2d7] text-[#6e6e73] text-[0.88rem] font-semibold rounded-full no-underline hover:bg-[#f5f5f7]">Cancel</a>
    </div>
  </form>
</div>
@endsection
