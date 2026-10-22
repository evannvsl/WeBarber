<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'WeBarber')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300&display=swap" rel="stylesheet" />
  <style>
    html { scroll-behavior: smooth; }
    body { -webkit-font-smoothing: antialiased; font-family: 'Inter', -apple-system, sans-serif; }
    .policy-list li::before { content: '—'; position: absolute; left: 0; color: #b8a060; font-weight: 700; }
    /* Navbar tidak tabrakan di layar kecil */
    .nav-link {
      font-size: 0.82rem;
      font-weight: 500;
      color: #6e6e73;
      text-decoration: none;
      padding: 0.2rem 0.75rem;
      border-radius: 9999px;
      letter-spacing: 0.02em;
      white-space: nowrap;
      transition: background-color 0.15s, color 0.15s;
    }
    .nav-link:hover { background-color: #e8e8ed; color: #0a0a0a; }
    .nav-link.active { font-weight: 600; color: #0a0a0a; background-color: #f5f5f7; }
    .nav-sep { color: #d2d2d7; padding: 0 0.1rem; font-size: 0.82rem; line-height: 1; user-select: none; }
    @media (max-width: 640px) {
      .nav-sep { display: none; }
      .nav-link { padding: 0.2rem 0.5rem; font-size: 0.75rem; }
    }
  </style>
  @stack('styles')
</head>
<body class="bg-white text-[#1d1d1f] leading-relaxed">

  {{-- Navigation --}}
  <header class="sticky top-0 z-50 h-[52px] flex items-center justify-between px-8 bg-white border-b border-[#d2d2d7] gap-4 max-sm:px-4">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="text-[1.03rem] font-bold tracking-tight text-[#0a0a0a] no-underline shrink-0">WeBarber</a>

    {{-- Nav links --}}
    <nav class="flex items-center min-w-0 overflow-hidden">
      {{-- Public links --}}
      <a href="{{ route('home') }}"     class="nav-link {{ request()->routeIs('home')     ? 'active' : '' }}">Home</a>
      <a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}">Menu</a>
      <a href="{{ route('barbers') }}"  class="nav-link {{ request()->routeIs('barbers')  ? 'active' : '' }}">Contact</a>

      @auth
        @if(auth()->user()->isAdmin())
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a>
        @elseif(auth()->user()->isBarber())
          <a href="{{ route('barber.dashboard') }}" class="nav-link {{ request()->routeIs('barber.*') ? 'active' : '' }}">Dashboard</a>
        @else
          <a href="{{ route('customer.history') }}"  class="nav-link {{ request()->routeIs('customer.history') ? 'active' : '' }}">History</a>
          <a href="{{ route('customer.profile') }}"  class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}">Profile</a>
        @endif
      @else
        <a href="{{ route('login') }}" class="nav-link">Login</a>
      @endauth
    </nav>
  </header>

  @yield('content')

  <footer class="border-t border-[#d2d2d7] bg-white px-4 py-6 text-center text-[0.78rem] tracking-[0.03em] text-[#aeaeb2]">
    <p>&copy; {{ date('Y') }} WeBarber. All rights reserved.</p>
  </footer>

  @stack('scripts')
</body>
</html>
