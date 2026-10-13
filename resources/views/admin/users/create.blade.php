@extends('layouts.dashboard')
@section('title', 'Add User')
@section('page-title', 'Add New User')

@section('content')
<div class="max-w-lg">
  <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white border border-[#d2d2d7] rounded-2xl p-8 flex flex-col gap-4 shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
    @csrf

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Full Name</label>
      <input type="text" name="name" value="{{ old('name') }}" required
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]" />
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" required
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]" />
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Phone</label>
      <input type="tel" name="phone" value="{{ old('phone') }}"
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]" />
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Role</label>
      <select name="role" required class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]">
        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
        <option value="barber"   {{ old('role') === 'barber'   ? 'selected' : '' }}>Barber</option>
        <option value="admin"    {{ old('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
      </select>
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Password</label>
      <input type="password" name="password" required
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]" />
    </div>

    <div class="flex flex-col gap-1.5">
      <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Confirm Password</label>
      <input type="password" name="password_confirmation" required
        class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none focus:border-[#111111]" />
    </div>

    <div class="flex items-center gap-3 pt-2">
      <button type="submit" class="px-6 py-2.5 bg-[#111111] text-white text-[0.88rem] font-semibold rounded-full hover:opacity-80 cursor-pointer border-0">Save User</button>
      <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 border border-[#d2d2d7] text-[#6e6e73] text-[0.88rem] font-semibold rounded-full no-underline hover:bg-[#f5f5f7]">Cancel</a>
    </div>
  </form>
</div>
@endsection
