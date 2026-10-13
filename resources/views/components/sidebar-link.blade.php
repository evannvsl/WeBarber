@props(['href', 'active' => false])

<a href="{{ $href }}"
   class="flex items-center px-3 py-2 rounded-lg text-[0.82rem] font-medium no-underline transition-colors
          {{ $active
              ? 'bg-white/10 text-white'
              : 'text-white/45 hover:bg-white/5 hover:text-white/75' }}">
  {{ $slot }}
</a>
