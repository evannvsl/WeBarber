@extends('layouts.dashboard')
@section('title', 'Users')
@section('page-title', 'Manage Users')

@section('content')
<div class="flex items-center justify-between mb-6">
  <p class="text-[0.85rem] text-[#6e6e73]">{{ $users->total() }} total users</p>
  <a href="{{ route('admin.users.create') }}" class="px-5 py-2 bg-[#111111] text-white text-[0.82rem] font-semibold rounded-full no-underline hover:opacity-75 transition-opacity">
    + Add User
  </a>
</div>

<div class="bg-white border border-[#d2d2d7] rounded-2xl overflow-hidden shadow-[0_1px_4px_rgba(0,0,0,0.04)]">
  <table class="w-full border-collapse text-[0.88rem]">
    <thead class="bg-[#f5f5f7]">
      <tr>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Name</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Email</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Role</th>
        <th class="text-left px-5 py-3.5 text-[0.7rem] font-bold text-[#6e6e73] uppercase tracking-[0.1em]">Phone</th>
        <th class="px-5 py-3.5"></th>
      </tr>
    </thead>
    <tbody class="divide-y divide-[#f5f5f7]">
      @forelse($users as $user)
      <tr class="hover:bg-[#f5f5f7] transition-colors">
        <td class="px-5 py-3.5 font-medium text-[#111111]">{{ $user->name }}</td>
        <td class="px-5 py-3.5 text-[#6e6e73]">{{ $user->email }}</td>
        <td class="px-5 py-3.5">
          <span class="inline-block text-[0.68rem] font-bold tracking-[0.06em] uppercase px-2 py-0.5 rounded-full border
            {{ $user->role === 'admin' ? 'bg-[#0a0a0a] text-white border-[#0a0a0a]' : ($user->role === 'barber' ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-blue-50 text-blue-700 border-blue-200') }}">
            {{ ucfirst($user->role) }}
          </span>
        </td>
        <td class="px-5 py-3.5 text-[#6e6e73]">{{ $user->phone ?? '—' }}</td>
        <td class="px-5 py-3.5">
          <div class="flex items-center gap-3 justify-end">
            <a href="{{ route('admin.users.edit', $user) }}" class="text-[0.78rem] font-semibold text-[#111111] no-underline hover:opacity-60">Edit</a>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-[0.78rem] font-semibold text-red-600 bg-transparent border-0 cursor-pointer hover:opacity-60">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      @empty
      <tr><td colspan="5" class="px-5 py-8 text-center text-[#6e6e73] text-[0.85rem]">No users found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
