@extends('layouts.app')
@section('title', 'WeBarber | Profile')

@section('content')

<section class="bg-[#f5f5f7] border-b border-[#d2d2d7] py-14 px-8 text-center">
  <p class="text-[0.68rem] font-bold tracking-[0.25em] uppercase text-[#b8a060] mb-2">Account</p>
  <h2 class="text-[clamp(1.8rem,4vw,2.8rem)] font-extrabold tracking-[-1px] text-[#111111] leading-none">Your Profile</h2>
</section>

<main class="max-w-[640px] mx-auto px-6 pb-24 pt-12">

  @if(session('success'))
  <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-[0.85rem] text-green-800">
    <span>✓</span> {{ session('success') }}
  </div>
  @endif

  {{-- Profile Info --}}
  <section class="mb-8 p-8 border border-[#d2d2d7] rounded-2xl bg-white">
    <h3 class="text-[1.1rem] font-bold text-[#111111] mb-6 pb-4 border-b border-[#f5f5f7]">Personal Information</h3>
    <form method="POST" action="{{ route('customer.profile.update') }}" class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Full Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111]" />
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111]" />
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Phone</label>
        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
          placeholder="08xxxxxxxxxx"
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] placeholder:text-[#aeaeb2]" />
      </div>

      <button type="submit"
        class="self-start px-6 py-2.5 bg-[#111111] text-white text-[0.88rem] font-semibold rounded-full transition-opacity hover:opacity-80 cursor-pointer border-0 mt-2">
        Save Changes
      </button>
    </form>
  </section>

  {{-- Change Password --}}
  <section class="p-8 border border-[#d2d2d7] rounded-2xl bg-white">
    <h3 class="text-[1.1rem] font-bold text-[#111111] mb-6 pb-4 border-b border-[#f5f5f7]">Change Password</h3>
    <form method="POST" action="{{ route('customer.profile.password') }}" class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Current Password</label>
        <input type="password" name="current_password" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111]" />
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">New Password</label>
        <input type="password" name="password" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111]" />
      </div>

      <div class="flex flex-col gap-1.5">
        <label class="text-[0.8rem] font-semibold text-[#3a3a3c]">Confirm New Password</label>
        <input type="password" name="password_confirmation" required
          class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111]" />
      </div>

      <button type="submit"
        class="self-start px-6 py-2.5 bg-[#111111] text-white text-[0.88rem] font-semibold rounded-full transition-opacity hover:opacity-80 cursor-pointer border-0 mt-2">
        Update Password
      </button>
    </form>
  </section>

  {{-- Logout --}}
  <section class="p-8 border border-[#ffd2d2] rounded-2xl bg-[#fff8f8] mt-8">
    <h3 class="text-[1.1rem] font-bold text-[#111111] mb-1">Sign Out</h3>
    <p class="text-[0.85rem] text-[#6e6e73] mb-5">Keluar dari akun WeBarber kamu. Kamu bisa login kembali kapan saja.</p>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit"
        class="px-6 py-2.5 bg-white border border-[#ffb3b3] text-[#c0392b] text-[0.88rem] font-semibold rounded-full transition-all hover:bg-[#c0392b] hover:text-white hover:border-[#c0392b] cursor-pointer">
        Logout dari akun ini
      </button>
    </form>
  </section>

</main>
@endsection
