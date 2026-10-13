@extends('layouts.auth')
@section('title', 'Register')

@section('content')
<div class="text-center mb-8">
  <h1 class="text-[2rem] font-extrabold tracking-[-0.8px] text-[#111111]">Create account.</h1>
  <p class="text-[0.88rem] text-[#6e6e73] mt-1">Join WeBarber and book your first session.</p>
</div>

<form method="POST" action="{{ route('register') }}" class="flex flex-col gap-4">
  @csrf

  <div class="flex flex-col gap-1.5">
    <label for="name" class="text-[0.8rem] font-semibold text-[#3a3a3c]">Full Name</label>
    <input
      type="text" id="name" name="name"
      value="{{ old('name') }}" required autofocus
      placeholder="Your name"
      class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] placeholder:text-[#aeaeb2]"
    />
  </div>

  <div class="flex flex-col gap-1.5">
    <label for="email" class="text-[0.8rem] font-semibold text-[#3a3a3c]">Email</label>
    <input
      type="email" id="email" name="email"
      value="{{ old('email') }}" required
      placeholder="you@example.com"
      class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] placeholder:text-[#aeaeb2]"
    />
  </div>

  <div class="flex flex-col gap-1.5">
    <label for="phone" class="text-[0.8rem] font-semibold text-[#3a3a3c]">Phone <span class="text-[#aeaeb2] font-normal">(optional)</span></label>
    <input
      type="tel" id="phone" name="phone"
      value="{{ old('phone') }}"
      placeholder="08xxxxxxxxxx"
      class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] placeholder:text-[#aeaeb2]"
    />
  </div>

  <div class="flex flex-col gap-1.5">
    <label for="password" class="text-[0.8rem] font-semibold text-[#3a3a3c]">Password</label>
    <input
      type="password" id="password" name="password"
      required placeholder="Min. 8 characters"
      class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] placeholder:text-[#aeaeb2]"
    />
  </div>

  <div class="flex flex-col gap-1.5">
    <label for="password_confirmation" class="text-[0.8rem] font-semibold text-[#3a3a3c]">Confirm Password</label>
    <input
      type="password" id="password_confirmation" name="password_confirmation"
      required placeholder="Repeat your password"
      class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] placeholder:text-[#aeaeb2]"
    />
  </div>

  <button type="submit"
    class="w-full py-2.5 bg-[#111111] text-white text-[0.9rem] font-semibold rounded-xl transition-opacity hover:opacity-80 cursor-pointer border-0 mt-2">
    Create account
  </button>
</form>

<p class="text-center text-[0.83rem] text-[#6e6e73] mt-6">
  Already have an account?
  <a href="{{ route('login') }}" class="font-semibold text-[#111111] no-underline border-b border-[#111111] pb-px">Sign in</a>
</p>
@endsection
