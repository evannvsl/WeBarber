@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<div class="text-center mb-8">
  <h1 class="text-[2rem] font-extrabold tracking-[-0.8px] text-[#111111]">Welcome back.</h1>
  <p class="text-[0.88rem] text-[#6e6e73] mt-1">Sign in to your WeBarber account.</p>
</div>

<form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
  @csrf

  <div class="flex flex-col gap-1.5">
    <label for="email" class="text-[0.8rem] font-semibold text-[#3a3a3c]">Email</label>
    <input
      type="email" id="email" name="email"
      value="{{ old('email') }}" required autofocus
      placeholder="you@example.com"
      class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] placeholder:text-[#aeaeb2]"
    />
  </div>

  <div class="flex flex-col gap-1.5">
    <label for="password" class="text-[0.8rem] font-semibold text-[#3a3a3c]">Password</label>
    <input
      type="password" id="password" name="password"
      required placeholder="••••••••"
      class="w-full px-4 py-2.5 text-[0.9rem] border border-[#d2d2d7] rounded-xl bg-white outline-none transition-colors focus:border-[#111111] placeholder:text-[#aeaeb2]"
    />
  </div>

  <label class="flex items-center gap-2 cursor-pointer">
    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-[#d2d2d7]" />
    <span class="text-[0.82rem] text-[#6e6e73]">Remember me</span>
  </label>

  <button type="submit"
    class="w-full py-2.5 bg-[#111111] text-white text-[0.9rem] font-semibold rounded-xl transition-opacity hover:opacity-80 cursor-pointer border-0 mt-2">
    Sign in
  </button>
</form>

<p class="text-center text-[0.83rem] text-[#6e6e73] mt-6">
  Don't have an account?
  <a href="{{ route('register') }}" class="font-semibold text-[#111111] no-underline border-b border-[#111111] pb-px">Register</a>
</p>
@endsection
