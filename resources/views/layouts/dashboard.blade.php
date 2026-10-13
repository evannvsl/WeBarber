<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'WeBarber') — Dashboard</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <style>
    html { scroll-behavior: smooth; }
    body { -webkit-font-smoothing: antialiased; font-family: 'Inter', -apple-system, sans-serif; }
  </style>
  @stack('styles')
</head>
<body class="bg-[#f5f5f7] text-[#1d1d1f] leading-relaxed">

  <div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-56 bg-[#0a0a0a] flex flex-col shrink-0 sticky top-0 h-screen overflow-y-auto">
      <div class="px-5 py-5 border-b border-white/10">
        <a href="{{ route('home') }}" class="text-[1rem] font-bold text-white no-underline tracking-tight">WeBarber</a>
        <p class="text-[0.65rem] font-medium text-white/35 uppercase tracking-[0.15em] mt-0.5">
          @if(auth()->user()->isAdmin()) Admin Panel
          @else Barber Panel
          @endif
        </p>
      </div>

      <nav class="flex-1 px-3 py-4 flex flex-col gap-0.5">
        @if(auth()->user()->isAdmin())
          <x-sidebar-link href="{{ route('admin.dashboard') }}"      :active="request()->routeIs('admin.dashboard')">Dashboard</x-sidebar-link>
          <x-sidebar-link href="{{ route('admin.users.index') }}"    :active="request()->routeIs('admin.users*')">Users</x-sidebar-link>
          <x-sidebar-link href="{{ route('admin.barbers.index') }}"  :active="request()->routeIs('admin.barbers*')">Barbers</x-sidebar-link>
          <x-sidebar-link href="{{ route('admin.services.index') }}" :active="request()->routeIs('admin.services*')">Services</x-sidebar-link>
          <x-sidebar-link href="{{ route('admin.schedules.index') }}" :active="request()->routeIs('admin.schedules*')">Schedules</x-sidebar-link>
          <x-sidebar-link href="{{ route('admin.bookings.index') }}" :active="request()->routeIs('admin.bookings*')">Bookings</x-sidebar-link>
          <x-sidebar-link href="{{ route('admin.payments.index') }}" :active="request()->routeIs('admin.payments*')">Payments</x-sidebar-link>
          <x-sidebar-link href="{{ route('admin.reports.index') }}"  :active="request()->routeIs('admin.reports*')">Reports</x-sidebar-link>
        @else
          <x-sidebar-link href="{{ route('barber.dashboard') }}" :active="request()->routeIs('barber.dashboard')">Dashboard</x-sidebar-link>
          <x-sidebar-link href="{{ route('barber.bookings') }}"  :active="request()->routeIs('barber.bookings')">Bookings</x-sidebar-link>
          <x-sidebar-link href="{{ route('barber.schedule') }}"  :active="request()->routeIs('barber.schedule')">Schedule</x-sidebar-link>
          <x-sidebar-link href="{{ route('barber.history') }}"   :active="request()->routeIs('barber.history')">History</x-sidebar-link>
        @endif
      </nav>

      <div class="px-3 py-4 border-t border-white/10">
        <div class="flex items-center gap-3 px-2 py-2 mb-2">
          <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-[0.85rem] font-bold text-white/75">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
          <div>
            <p class="text-[0.8rem] font-semibold text-white leading-tight">{{ auth()->user()->name }}</p>
            <p class="text-[0.65rem] text-white/35">{{ ucfirst(auth()->user()->role) }}</p>
          </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left text-[0.78rem] font-medium text-white/45 px-2 py-1.5 rounded-lg hover:bg-white/5 hover:text-white/75 transition-colors cursor-pointer border-0 bg-transparent">
            Logout
          </button>
        </form>
      </div>
    </aside>

    {{-- Main content --}}
    <div class="flex-1 flex flex-col min-w-0">
      <header class="h-14 flex items-center justify-between px-8 bg-white border-b border-[#d2d2d7]">
        <h1 class="text-[0.95rem] font-bold text-[#111111] tracking-tight">@yield('page-title', 'Dashboard')</h1>
        <div class="flex items-center gap-3">
          <a href="{{ route('home') }}" class="text-[0.78rem] text-[#6e6e73] no-underline hover:text-[#111111]">← Back to site</a>
        </div>
      </header>

      <main class="flex-1 px-8 py-8 max-w-6xl w-full">
        {{-- Flash messages --}}
        @if(session('success'))
          <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-[0.85rem] text-green-800">
            <span>✓</span> {{ session('success') }}
          </div>
        @endif
        @if($errors->any())
          <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-[0.85rem] text-red-800">
            <ul class="list-none p-0 m-0 flex flex-col gap-1">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @yield('content')
      </main>
    </div>
  </div>

  @stack('scripts')
</body>
</html>
