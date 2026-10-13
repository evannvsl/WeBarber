<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'WeBarber')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    html { scroll-behavior: smooth; }
    body { -webkit-font-smoothing: antialiased; font-family: 'Inter', -apple-system, sans-serif; }
    .policy-list li::before { content: '—'; position: absolute; left: 0; color: #b8a060; font-weight: 700; }
  </style>
  @stack('styles')
</head>
<body class="bg-white text-[#1d1d1f] leading-relaxed">

  {{-- Navigation --}}
  <header class="sticky top-0 z-50 h-[52px] flex items-center justify-between px-10 bg-white/80 backdrop-blur-xl backdrop-saturate-200 border-b border-[#d2d2d7] max-sm:px-4">
    <a href="{{ route('home') }}" class="text-[1.05rem] font-bold tracking-tight text-[#111111] no-underline">WeBarber</a>
    <nav class="flex items-center gap-1">
      <a href="{{ route('home') }}"     class="text-[0.83rem] font-medium text-[#6e6e73] no-underline px-3 py-1 rounded-full transition-colors hover:bg-[#f5f5f7] hover:text-[#111111] {{ request()->routeIs('home') ? 'text-[#111111] bg-[#f5f5f7]' : '' }}">Home</a>|
      <a href="{{ route('services') }}" class="text-[0.83rem] font-medium text-[#6e6e73] no-underline px-3 py-1 rounded-full transition-colors hover:bg-[#f5f5f7] hover:text-[#111111] {{ request()->routeIs('services') ? 'text-[#111111] bg-[#f5f5f7]' : '' }}">Menu</a>|
      <a href="{{ route('barbers') }}"  class="text-[0.83rem] font-medium text-[#6e6e73] no-underline px-3 py-1 rounded-full transition-colors hover:bg-[#f5f5f7] hover:text-[#111111] {{ request()->routeIs('barbers') ? 'text-[#111111] bg-[#f5f5f7]' : '' }}">Barbers</a>|
      @auth
        @if(auth()->user()->isAdmin())
          <a href="{{ route('admin.dashboard') }}" class="text-[0.83rem] font-medium text-[#6e6e73] no-underline px-3 py-1 rounded-full hover:bg-[#f5f5f7] hover:text-[#111111]">Admin</a>|
        @elseif(auth()->user()->isBarber())
          <a href="{{ route('barber.dashboard') }}" class="text-[0.83rem] font-medium text-[#6e6e73] no-underline px-3 py-1 rounded-full hover:bg-[#f5f5f7] hover:text-[#111111]">Dashboard</a>|
        @else
          <a href="{{ route('customer.booking') }}" class="text-[0.83rem] font-medium text-[#6e6e73] no-underline px-3 py-1 rounded-full hover:bg-[#f5f5f7] hover:text-[#111111]">Booking</a>|
          <a href="{{ route('customer.history') }}"  class="text-[0.83rem] font-medium text-[#6e6e73] no-underline px-3 py-1 rounded-full hover:bg-[#f5f5f7] hover:text-[#111111]">Riwayat</a>|
        @endif
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button type="submit" class="text-[0.83rem] font-medium text-[#6e6e73] px-3 py-1 rounded-full cursor-pointer transition-colors hover:bg-[#f5f5f7] hover:text-[#111111] border-0 bg-transparent">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}"    class="text-[0.83rem] font-medium text-[#6e6e73] no-underline px-3 py-1 rounded-full hover:bg-[#f5f5f7] hover:text-[#111111]">Login</a>
      @endauth
    </nav>
  </header>

  @yield('content')

  <footer class="text-center py-6 text-[0.78rem] text-[#aeaeb2] border-t border-[#d2d2d7] bg-[#f5f5f7] tracking-[0.01em]">
    <p>&copy; {{ date('Y') }} WeBarber. All rights reserved.</p>
  </footer>

  @stack('scripts')
</body>
</html>
