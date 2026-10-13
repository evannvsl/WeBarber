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
  </style>
</head>
<body class="bg-[#f5f5f7] text-[#1d1d1f] min-h-screen flex flex-col">

  <header class="h-[52px] flex items-center justify-center border-b border-[#d2d2d7] bg-white/80 backdrop-blur-xl">
    <a href="{{ route('home') }}" class="text-[1.05rem] font-bold tracking-tight text-[#111111] no-underline">WeBarber</a>
  </header>

  <main class="flex-1 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-[400px]">
      @if($errors->any())
        <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-[0.85rem] text-red-800">
          @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
      @yield('content')
    </div>
  </main>

  <footer class="text-center py-4 text-[0.75rem] text-[#aeaeb2] border-t border-[#d2d2d7]">
    &copy; {{ date('Y') }} WeBarber
  </footer>
</body>
</html>
